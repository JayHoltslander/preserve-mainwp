<?php
/**
 * Plugin Name: Preserve MainWP Connection
 * Plugin URI: https://wordpress.org/plugins/preserve-mainwp/
 * Description: Preserves MainWP Child connection details from being overwritten during WP Migrate (formerly WP Migrate DB Pro) push/pull operations and database imports.
 * Version: 2.0.0
 * Author: Jay Holtslander
 * Author URI: https://jay.holtslander.ca
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: preserve-mainwp
 * Requires at least: 5.6
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Preserve_MainWP_Connection {

	/**
	 * Comprehensive list of all option keys used by MainWP Child.
	 *
	 * @return array List of option key strings.
	 */
	private static function get_mainwp_option_keys() {
		return array(
			'mainwp_child_uniqueId',
			'mainwp_child_pubkey',
			'mainwp_child_server',
			'mainwp_child_nonce',
			'mainwp_child_siteid',
			'mainwp_child_auth',
			'mainwp_child_nossl_key',
			'mainwp_child_connected_admin',
			'mainwp_child_openssl_sign_algo',
			'mainwp_security',
		);
	}

	public function __construct() {
		// 1. Native WP Migrate DB Pro Preserved Options Filter (Handles Pull migrations)
		add_filter( 'wpmdb_preserved_options', array( $this, 'preserve_wpmdb_options' ) );

		// 2. Pre-migration backup (Handles Push migrations on the receiving target site)
		add_action( 'wpmdb_respond_remote_initiate', array( $this, 'backup_local_mainwp_options' ) );
		add_action( 'wpmdb_initiate_migration', array( $this, 'backup_local_mainwp_options' ) );

		// 3. Post-migration restoration (Restores receiving target site's native keys)
		add_action( 'wpmdb_remote_finalize', array( $this, 'restore_local_mainwp_options' ) );
		add_action( 'wpmdb_migration_complete', array( $this, 'restore_local_mainwp_options' ) );
		add_action( 'wpmdb_after_finalize_migration', array( $this, 'restore_local_mainwp_options' ) );
	}

	/**
	 * Appends all MainWP option keys to WP Migrate DB Pro's preserved options filter.
	 *
	 * @param array $options Current array of preserved options.
	 * @return array Merged array of preserved options.
	 */
	public function preserve_wpmdb_options( $options ) {
		if ( ! is_array( $options ) ) {
			$options = array();
		}
		return array_values( array_unique( array_merge( $options, self::get_mainwp_option_keys() ) ) );
	}

	/**
	 * Backs up current site's native MainWP options to a transient prior to DB import.
	 */
	public function backup_local_mainwp_options() {
		global $wpdb;
		$keys         = self::get_mainwp_option_keys();
		$placeholders = implode( "','", array_map( 'esc_sql', $keys ) );

		$results = $wpdb->get_results(
			"SELECT option_name, option_value, autoload FROM {$wpdb->options} WHERE option_name IN ('{$placeholders}')",
			ARRAY_A
		);

		if ( ! empty( $results ) ) {
			set_transient( '_preserve_mainwp_backup', $results, 2 * HOUR_IN_SECONDS );
		}
	}

	/**
	 * Restores the site's native MainWP options from transient after DB import completes.
	 */
	public function restore_local_mainwp_options() {
		$backup = get_transient( '_preserve_mainwp_backup' );
		if ( false !== $backup && is_array( $backup ) ) {
			global $wpdb;
			foreach ( $backup as $opt ) {
				if ( ! empty( $opt['option_name'] ) ) {
					$wpdb->query( $wpdb->prepare(
						"INSERT INTO {$wpdb->options} (option_name, option_value, autoload) VALUES (%s, %s, %s) ON DUPLICATE KEY UPDATE option_value = %s, autoload = %s",
						$opt['option_name'],
						$opt['option_value'],
						$opt['autoload'],
						$opt['option_value'],
						$opt['autoload']
					) );
				}
			}
			delete_transient( '_preserve_mainwp_backup' );
		}
	}
}

new Preserve_MainWP_Connection();
