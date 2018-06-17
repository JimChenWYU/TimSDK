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
    'sdkappid'    => '14000xxxx',
    'identifier'  => 'admin',
    'prikey'      => 'Your private key',
    'pubkey'      => 'Your public key',
    'http' => [
        'timeout'  => 5,
        'base_uri' => 'Your base url'
    ],
];

$app = new TimCloud($options);
$response = $app->request(API::DIRTY_WORDS_GET);

var_dump($response);
```

## Documentation

持续更新中

## License

[MIT](https://opensource.org/licenses/MIT/)