=== xsx-debug ===
Plugin Name:        xsx-debug
Description:        This plugin adds a button to the toolbar to quickly enable/disable PHP Debug Messages
Version:            0.0.5
Text Domain:        xsxdebug
Domain Path:        /languages
Requires PHP:       5.6
Requires:           1.0.0
Tested:             4.9.99
Author:             Gieffe edizioni
Author URI:         https://www.gieffeedizioni.it
Plugin URI:         https://software.gieffeedizioni.it
Download link:      https://github.com/xxsimoxx/xsx-debug/releases/download/v0.0.5/xsx-debug.zip
License:            GPLv2
License URI:        https://www.gnu.org/licenses/gpl-2.0.html

This plugin adds a button to the toolbar to quickly enable/disable PHP Debug Messages
== Description ==

# xsx-debug
**This plugin adds a button to the toolbar to quickly enable/disable PHP Debug Messages**

When **PHP DEBUG ENABLED** those directives are set:
```php
	ini_set('display_startup_errors', true);
	error_reporting(E_ALL);
	ini_set('display_errors', true);
```

Inspired from [this article by John Alarcon](https://codepotent.com/improved-php-error-reporting-in-classicpress/), output is formatted.

== Disclaimer ==

- This plugin is intended for use in staging sites. *Delete it when you go live*.
- On plugin activation debugging is automatically switched off
- **PHP erors, warnings, etc... are printed for everyone, not just Administrator**.
- You will be notified if you don't have permission to modify necessari ini settings.
