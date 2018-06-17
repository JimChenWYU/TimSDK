## Requirement

1. PHP >= 5.5.9
2. **[Composer](https://getcomposer.org/)**
3. openssl 拓展

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

更多请参考API常量请看 [API常量](https://github.com/JimChenWYU/TimSDK/blob/master/src/Core/API.php)

## Documentation

持续更新中

## License

[MIT](https://opensource.org/licenses/MIT/)