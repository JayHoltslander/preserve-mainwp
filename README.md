# Preserve MainWP Connection

[![WordPress Plugin Version](https://img.shields.io/wordpress/plugin/v/preserve-mainwp.svg)](https://wordpress.org/plugins/preserve-mainwp/)
[![WordPress Plugin Rating](https://img.shields.io/wordpress/plugin/r/preserve-mainwp.svg)](https://wordpress.org/plugins/preserve-mainwp/)
[![WordPress Plugin Downloads](https://img.shields.io/wordpress/plugin/dt/preserve-mainwp.svg)](https://wordpress.org/plugins/preserve-mainwp/)
[![License: GPL v2+](https://img.shields.io/badge/License-GPL%20v2%2B-blue.svg)](https://www.gnu.org/licenses/gpl-2.0.html)

Preserve [MainWP](https://mainwp.com/)'s connection details from being overwritten by [WP Migrate](https://deliciousbrains.com/wp-migrate-db-pro/) (formerly WP Migrate DB Pro) when pushing or pulling databases between environments.

## Problem

When using MainWP to manage WordPress child sites and WP Migrate to perform database push/pull operations between staging, development, and production environments, WP Migrate overwrites the `wp_options` table values containing MainWP's child site authentication details. This severs the connection to the MainWP Dashboard, requiring manual re-connection after every migration.

## Solution

This lightweight, zero-configuration WordPress plugin hooks into WP Migrate's `wpmdb_preserved_options` filter to ensure that MainWP connection keys (`mainwp_child_uniqueId`, `mainwp_child_pubkey`, `mainwp_child_server`, `mainwp_child_nonce`, `mainwp_child_subkey`) are automatically excluded from being overwritten during migrations.

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
