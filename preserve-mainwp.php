<?php
/**
 * Plugin Name: Preserve MainWP Connection
 * Plugin URI: https://wordpress.org/plugins/preserve-mainwp/
 * Description: Preserve MainWP's connection details from being overwritten by WP Migrate (formerly WP Migrate DB Pro) when pushing or pulling.
 * Version: 1.1.0
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

/**
 * Filter WP Migrate preserved options to include MainWP Child site connection settings.
 *
 * @param array $options Array of preserved option names.
 * @return array Array of preserved option names including MainWP connection options.
 */
add_filter( 'wpmdb_preserved_options', function ( $options ) {
	$mainwp_options = [
		'mainwp_child_uniqueId',
		'mainwp_child_pubkey',
		'mainwp_child_server',
		'mainwp_child_nonce',
		'mainwp_child_subkey',
	];

	if ( ! is_array( $options ) ) {
		$options = [];
	}

	return array_merge( $options, $mainwp_options );
} );
