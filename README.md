# xsx-debug
**This plugin adds a button to the toolbar to quickly enable/disable PHP Debug Messages**

When **PHP DEBUG ENABLED** those directives are set:
```php
	ini_set('display_startup_errors', true);
	error_reporting(E_ALL);
	ini_set('display_errors', true);
```

Inspired from [this article by John Alarcon](https://codepotent.com/improved-php-error-reporting-in-classicpress/), output is formatted.

## Disclaimer and warnings
- This plugin is intended for use in staging sites. *Delete it when you go live*.
- On plugin activation debugging is automatically switched off
- **PHP erors, warnings, etc... are printed for everyone, not just Administrator**.
- You will be notified if you don't have permission to modify necessari ini settings.
