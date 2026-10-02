=== Preserve MainWP Connection ===
Contributors: jasonh1234
Tags: deliciousbrains, mainwp, migratedbpro, database, wp-migrate
Requires at least: 5.6
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 2.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Preserve MainWP's connection details from being overwritten by WP Migrate (formerly WP Migrate DB Pro) when pushing or pulling.

== Description ==

Preserve [MainWP](https://mainwp.com/)'s connection details from being overwritten by [WP Migrate](https://deliciousbrains.com/wp-migrate-db-pro/) and severing the connection when pushing or pulling.

If you use MainWP to manage your WordPress sites and WP Migrate to clone sites between environments, you'll find that your site's connections to MainWP are constantly being disconnected by the push/pull operations of WP Migrate. This plugin prevents the database fields used for MainWP's connection details from being overwritten by WP Migrate during both Push and Pull operations, saving you from having to reconnect the site after every migration.

== Installation ==

1. Upload `preserve-mainwp.php` to the `/wp-content/plugins/preserve-mainwp/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Does this plugin require any configuration? =

No. It works out-of-the-box ("set and forget") as soon as it is activated.

= Which migration tools are supported? =

It preserves settings for WP Migrate (formerly WP Migrate DB Pro / Delicious Brains).

== Changelog ==

= 2.0.0 =
* Complete refactor to OOP architecture (`Preserve_MainWP_Connection`).
* Expanded preserved keys to all 10 MainWP Child authentication keys (`siteid`, `auth`, `connected_admin`, `nossl_key`, `openssl_sign_algo`, `security`).
* Added pre-migration transient backups (`_preserve_mainwp_backup`) on initiation hooks.
* Added post-migration DB restoration on finalization hooks to prevent connection loss during Push migrations.
* Updated compatibility declaration to WordPress 7.1.

= 1.1.0 =
* Modernized code structure and PHP 7.4+ compatibility.
* Added support for `mainwp_child_subkey` option.
* Updated WordPress and PHP version requirements.
* Added GitHub Actions workflow for WordPress.org SVN automated deployment.

= 1.0 =
* Initial release
