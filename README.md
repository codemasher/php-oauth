# chillerlan/php-oauth
A PHP7.2+ OAuth1/2 client with an integrated API wrapper, [loosely based](https://github.com/codemasher/PHPoAuthLib) on [Lusitanian/PHPoAuthLib](https://github.com/Lusitanian/PHPoAuthLib).

[![Packagist version][packagist-badge]][packagist]
[![License][license-badge]][license]
[![Travis CI][travis-badge]][travis]
[![CodeCov][coverage-badge]][coverage]
[![Scrunitizer CI][scrutinizer-badge]][scrutinizer]
[![Packagist downloads][downloads-badge]][downloads]
[![PayPal donate][donate-badge]][donate]

[packagist-badge]: https://img.shields.io/packagist/v/chillerlan/php-oauth.svg?style=flat-square
[packagist]: https://packagist.org/packages/chillerlan/php-oauth
[license-badge]: https://img.shields.io/github/license/chillerlan/php-oauth.svg?style=flat-square
[license]: https://github.com/chillerlan/php-oauth/blob/master/LICENSE
[travis-badge]: https://img.shields.io/travis/chillerlan/php-oauth.svg?style=flat-square
[travis]: https://travis-ci.org/chillerlan/php-oauth
[coverage-badge]: https://img.shields.io/codecov/c/github/chillerlan/php-oauth.svg?style=flat-square
[coverage]: https://codecov.io/github/chillerlan/php-oauth
[scrutinizer-badge]: https://img.shields.io/scrutinizer/g/chillerlan/php-oauth.svg?style=flat-square
[scrutinizer]: https://scrutinizer-ci.com/g/chillerlan/php-oauth
[downloads-badge]: https://img.shields.io/packagist/dt/chillerlan/php-oauth.svg?style=flat-square
[downloads]: https://packagist.org/packages/chillerlan/php-oauth/stats
[donate-badge]: https://img.shields.io/badge/donate-paypal-ff33aa.svg?style=flat-square
[donate]: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=WLYUNAT9ZTJZ4

# Documentation
## Requirements
- PHP 7.2+
- the [Sodium](http://php.net/manual/book.sodium.php) extension for token encryption
- a [PSR-18](https://www.php-fig.org/psr/psr-18/) compatible HTTP client library of your choice ([there is one included](https://github.com/chillerlan/php-httpinterface), though)
  - optional [PSR-17](https://www.php-fig.org/psr/psr-17/) compatible Request-, Response- and UriFactories

For documentation of the core components, see [`chillerlan/php-oauth-core`](https://github.com/chillerlan/php-oauth-core)


## Supported Providers

[...]

(PR welcome!)

## Installation
**requires [composer](https://getcomposer.org)**

`composer.json` (note: replace `dev-master` with a [version boundary](https://getcomposer.org/doc/articles/versions.md))
```json
{
	"require": {
		"php": "^7.2",
		"chillerlan/php-oauth": "dev-master"
	}
}
```

Profit!

## Usage

[...]

# Disclaimer
OAuth tokens are secrets and should be treated as such. Store them in a safe place,
[consider encryption](http://php.net/manual/book.sodium.php).<br/>
I won't take responsibility for stolen auth tokens. Use at your own risk.
