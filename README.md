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