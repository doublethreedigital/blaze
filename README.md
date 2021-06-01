![Banner](https://raw.githubusercontent.com/doublethreedigital/zippy/main/banner.png)

## Zippy

Zippy allows you to zip around the Statamic Control Panel through the power of search. It's basically [Alfred](https://www.alfredapp.com/), if it lived in the CP.

This repository contains the source code for Zippy. While Zippy itself is free and doesn't require a license, you can [donate to Duncan](https://duncanmcclean.com/donate), the developer behind it to show your appreciation.

## Installation

1. Install via Composer `composer require doublethreedigital/zippy`
2. To optionally publish a config file, run: `php artisan vendor:publish --tag="zippy-config"`

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

* [**Issue Tracker**](https://github.com/doublethreedigital/zippy/issues): Find & report bugs in Zippy
* [**Email**](mailto:duncan@doublethree.digital): Support from the developer behind the addon

---

<p>
<a href="https://statamic.com"><img src="https://img.shields.io/badge/Statamic-3.0+-FF269E?style=for-the-badge" alt="Compatible with Statamic v3"></a>
<a href="https://packagist.org/packages/doublethreedigital/zippy/stats"><img src="https://img.shields.io/packagist/v/doublethreedigital/zippy?style=for-the-badge" alt=":addonName on Packagist"></a>
</p>
