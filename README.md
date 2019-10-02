# xsx-debug
**This plugin adds a button to the toolbar to quickly enable/disable PHP Debug Messages**

When **PHP DEBUG ENABLED** those directives are set:
```php
	ini_set('display_startup_errors', true);
	error_reporting(E_ALL);
	ini_set('display_errors', true);
```

Inspired from [this article by John Alarcon](https://codepotent.com/improved-php-error-reporting-in-classicpress/), output is formatted.

## Updates
This plugin supports [GitHub Updater](https://github.com/afragen/github-updater).

## Disclaimer and warnings
- This plugin is intended for use in staging sites. *Delete it when you go live*.
- On plugin activation debugging is automatically switched off
- **PHP erors, warnings, etc... are printed for everyone, not just Administrator**.
- You will be notified if you don't have permission to modify necessari ini settings.

## Changelog
* 2019/09/24 v. 0.0.4-dev
  * Bugfix closed issue #1
* 2019/09/24 v. 0.0.3
  * Bugfix ("Alive" was printed in console under certain conditions)
  * Support for [GitHub Updater](https://github.com/afragen/github-updater)
* 2019/09/10 v. 0.0.2 work in progress
  * more like Classicpress color scheming
  * added error styling
* 2019/09/03 v. 0.0.1
  * first commit
