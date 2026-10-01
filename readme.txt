=== Preserve MainWP Connection ===
Contributors: jasonh1234
Tags: deliciousbrains, mainwp, migratedbpro, database, wp-migrate
Requires at least: 5.6
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Preserve MainWP's connection details from being overwritten by WP Migrate (formerly WP Migrate DB Pro) when pushing or pulling.

== Description ==

Preserve [MainWP](https://mainwp.com/)'s connection details from being overwritten by [WP Migrate](https://deliciousbrains.com/wp-migrate-db-pro/) and severing the connection when pushing or pulling.

If you use MainWP to manage your WordPress sites and WP Migrate to clone sites between environments, you'll find that your site's connections to MainWP are constantly being disconnected by the push/pull operations of WP Migrate. This simple plugin prevents the database fields used for MainWP's connection details from being overwritten by WP Migrate, saving you from having to reconnect the site after every push or pull.

== Installation ==

1. Upload `preserve-mainwp.php` to the `/wp-content/plugins/preserve-mainwp/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Does this plugin require any configuration? =

No. It works out-of-the-box ("set and forget") as soon as it is activated.

= Which migration tools are supported? =

It preserves settings for WP Migrate (formerly WP Migrate DB Pro / Delicious Brains).

== Changelog ==

= 1.1.0 =
* Modernized code structure and PHP 7.4+ compatibility.
* Added support for `mainwp_child_subkey` option.
* Updated WordPress and PHP version requirements.
* Added GitHub Actions workflow for WordPress.org SVN automated deployment.

= 1.0 =
* Initial release
