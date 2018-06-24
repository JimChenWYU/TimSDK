# TimSDK

<p align="center">

[![Build Status](https://www.travis-ci.org/JimChenWYU/TimSDK.svg?branch=master)](https://www.travis-ci.org/JimChenWYU/TimSDK)
[![Latest Stable Version](https://poser.pugx.org/jimchen/tim-sdk/v/stable)](https://packagist.org/packages/jimchen/tim-sdk)
[![Latest Unstable Version](https://poser.pugx.org/jimchen/tim-sdk/v/unstable)](https://packagist.org/packages/jimchen/tim-sdk)
[![Build Status](https://scrutinizer-ci.com/g/JimChenWYU/TimSDK/badges/build.png?b=master)](https://scrutinizer-ci.com/g/JimChenWYU/TimSDK/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/JimChenWYU/TimSDK/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/JimChenWYU/TimSDK/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/JimChenWYU/TimSDK/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/JimChenWYU/TimSDK/?branch=master)
[![Total Downloads](https://poser.pugx.org/jimchen/tim-sdk/downloads)](https://packagist.org/packages/jimchen/tim-sdk)
[![License](https://poser.pugx.org/jimchen/tim-sdk/license)](https://packagist.org/packages/jimchen/tim-sdk)

</p> 

<p align="center">
IM Sdk for Tencent Instant Messaging.
</p>

## Requirement

1. PHP >= 5.5.9
2. **[Composer](https://getcomposer.org/)**
3. Openssl Extension

## Installation

```bash
$ composer require jimchen/tim-sdk -vvv
```

## Usage
Basic Usage:

```php
use TimSDK;
use TimSDK\Core\API;

$options = [
  'app_id'      => '14000xxxx',
  'identifier'  => 'admin',
  'private_key' => 'Your private key',
  'public_key'  => 'Your public key',
  'http'        => [
	'timeout'  => 5,
	'base_uri' => 'Your base url',
  ],
];

$app = new TimCloud($options);

/**
 * Call api uri
 */
$response = $app->request(API::DIRTY_WORDS_GET);

/**
 * or call api alias
 */
$response = $app->request('DIRTY_WORDS_GET');

/**
 * or call a magic function
 */
$response = $app->requestDirtyWordsGet();

var_dump($response);
```

more [API Constants](https://github.com/JimChenWYU/TimSDK/blob/master/src/Core/API.php)

more details focus on this [demo](https://github.com/JimChenWYU/TimSDK-example)

## Documentation

1. [Configuration Parameters](https://github.com/JimChenWYU/TimSDK/tree/master/docs/config.md)
2. [TimCloud](https://github.com/JimChenWYU/TimSDK/tree/master/docs/tim-cloud.md)

## License

[MIT](https://opensource.org/licenses/MIT/)