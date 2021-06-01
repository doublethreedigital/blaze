![Banner](https://raw.githubusercontent.com/doublethreedigital/zippy/main/banner.png)

## Addon Boilerplate

This repository contains the source code for zippy. zippy is a commercial addon, to use it in production, you'll need to [purchase a license](https://statamic.com/zippy).

## Installation

1. Install via Composer `composer require doublethreedigital/zippy`
2. Publish configuration, assets etc `php artisan vendor:publish --provider="doublethreedigital/zippy"`

## Documentation

### Configuration

This addon provides its own configuration file. You can use this to configure the API keys and other options.

```php
return [
    //
];
```

## Security

From a security perspective, only the latest version will receive a security release if a vulnerability is found.

If you discover a security vulnerability within zippy, please report it [via email](mailto:duncan@doublethree.digital) straight away. Please don't report security issues in the issue tracker.

## Resources

* [**Issue Tracker**](https://github.com/doublethreedigital/zippy/issues): Find & report bugs in :addonName
* [**Email**](mailto:duncan@doublethree.digital): Support from the developer behind the addon

---

<p>
<a href="https://statamic.com"><img src="https://img.shields.io/badge/Statamic-3.0+-FF269E?style=for-the-badge" alt="Compatible with Statamic v3"></a>
<a href="https://packagist.org/packages/doublethreedigital/zippy/stats"><img src="https://img.shields.io/packagist/v/doublethreedigital/zippy?style=for-the-badge" alt=":addonName on Packagist"></a>
</p>

Generated using [`doublethreedigital/addon-boilerplate`](https://github.com/doublethreedigital/addon-boilerplate)
