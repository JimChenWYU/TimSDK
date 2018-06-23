## Requirement

1. PHP >= 5.5.9
2. **[Composer](https://getcomposer.org/)**
3. openssl 拓展

## Installation

```bash
$ composer require jimchen/tim-sdk -vvv
```

## Usage
基本使用:

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
$response = $app->request(API::DIRTY_WORDS_GET);

var_dump($response);
```

更多[API常量](https://github.com/JimChenWYU/TimSDK/blob/master/src/Core/API.php)

更多详细demo可以关注此[repo](https://github.com/JimChenWYU/TimSDK-example)

## Documentation

1. [Configuration Parameters](https://github.com/JimChenWYU/TimSDK/tree/master/docs/config.md)
2. [TimCloud](https://github.com/JimChenWYU/TimSDK/tree/master/docs/tim-cloud.md)

## License

[MIT](https://opensource.org/licenses/MIT/)