# Preserve MainWP Connection (v2.0)

[![WordPress Plugin Version](https://img.shields.io/wordpress/plugin/v/preserve-mainwp.svg)](https://wordpress.org/plugins/preserve-mainwp/)
[![WordPress Plugin Rating](https://img.shields.io/wordpress/plugin/r/preserve-mainwp.svg)](https://wordpress.org/plugins/preserve-mainwp/)
[![WordPress Plugin Downloads](https://img.shields.io/wordpress/plugin/dt/preserve-mainwp.svg)](https://wordpress.org/plugins/preserve-mainwp/)
[![License: GPL v2+](https://img.shields.io/badge/License-GPL%20v2%2B-blue.svg)](https://www.gnu.org/licenses/gpl-2.0.html)

Preserve [MainWP](https://mainwp.com/)'s connection details from being overwritten by [WP Migrate](https://deliciousbrains.com/wp-migrate-db-pro/) (formerly WP Migrate DB Pro) during both **Push** and **Pull** database migrations between environments.

## Problem

When using MainWP to manage WordPress child sites and WP Migrate to perform database push/pull operations between staging, development, and production environments, WP Migrate overwrites the `wp_options` table values containing MainWP's child site authentication details. 

Standard option filters (`wpmdb_preserved_options`) work for Pull operations, but during Push operations the exporting site reads its own keys and generates SQL insert statements that overwrite the target receiving site's keys upon import.

## Solution (v2.0)

Version 2.0 introduces a dual-layer preservation strategy:
1. **Preserved Options Filter:** Appends all 10 MainWP Child keys (`uniqueId`, `pubkey`, `server`, `nonce`, `siteid`, `auth`, `nossl_key`, `connected_admin`, `openssl_sign_algo`, `security`) to WP Migrate's `wpmdb_preserved_options` filter.
2. **Pre-Migration Transient Backup & Post-Migration Restoration:** Hooks into `wpmdb_respond_remote_initiate` / `wpmdb_initiate_migration` to snapshot the local site's native MainWP options into a temporary 2-hour transient (`_preserve_mainwp_backup`). Upon completion (`wpmdb_remote_finalize` / `wpmdb_migration_complete` / `wpmdb_after_finalize_migration`), it restores the native keys back into `wp_options`.

## Installation

1. Download or clone this repository into `/wp-content/plugins/preserve-mainwp/`
2. Activate **Preserve MainWP Connection** in the WordPress admin panel (`Plugins > Installed Plugins`).

## Requirements

- **WordPress:** 5.6 or higher
- **PHP:** 7.4 or higher
- **WP Migrate / WP Migrate DB Pro**

## Automated Releases

This repository uses GitHub Actions (`10up/action-wordpress-plugin-deploy`) to automatically publish new tagged releases to the official [WordPress.org Plugin Directory](https://wordpress.org/plugins/preserve-mainwp/).

## License

Licensed under [GPLv2 or later](LICENSE).
