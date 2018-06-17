## Configuration Parameters

example:
```php
// Array
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
```
or
```php
use TimSDK\Support\Collection;

// Collection
$options = new Collection([
  'app_id'      => '14000xxxx',
  'identifier'  => 'admin',
  'private_key' => 'Your private key',
  'public_key'  => 'Your public key',
  'http'        => [
	'timeout'  => 5,
	'base_uri' => 'Your base url',
  ],
]);
```
or
```php
// Json
$options = json_encode([
  'app_id'      => '14000xxxx',
  'identifier'  => 'admin',
  'private_key' => 'Your private key',
  'public_key'  => 'Your public key',
  'http'        => [
	'timeout'  => 5,
	'base_uri' => 'Your base url',
  ],
]);
```

更多可查看 [这里](https://github.com/JimChenWYU/TimSDK/blob/master/src/Support/Collection.php#L351)
