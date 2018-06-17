## TimCloud

### 1. Configuration Parameters Reset

实例化之后可以重新设置`app_id`, `identifier`, `private_key`, `public_key`

```php
use TimSDK/TimCloud;

$options = [
...
];

$app = new TimCloud($options);
$app->setAppId($app_id);
$app->setIdentifier($identifier);
$app->setPrivateKey($private_key);
$app->setPublicKey($public_key);

var_dump($app->config)
``` 

### 2. Request API

```php
$response = $app->request($uri, $body, $options);
```
其中`$uri`可以查看 [API常量](https://github.com/JimChenWYU/TimSDK/blob/master/src/Core/API.php)

`$body` 为API的请求包体，具体参数查看请到[腾讯云通信官网](https://cloud.tencent.com/document/product/269/1520)

[example](https://cloud.tencent.com/document/product/269/4123):
```json
{
  "MsgRandom": 20160201,
  "MsgBody": [
    {
      "MsgType": "TIMTextElem",
      "MsgContent": {
        "Text": "hi, beauty"
      }
    }
  ]
}
```
Array:
```php
$body = [
  'MsgRandom' => 20160201,
  'MsgBody' => [
    [
      'MsgType'    => 'TIMTextElem',
      'MsgContent' => [
        'Text' => 'hi, beauty'
      ]
    ]
  ]
];
```
String:
```php
use TimSDK\Support\Json;

$body = Json::encode([
  'MsgRandom' => 20160201,
  'MsgBody' => [
    [
      'MsgType'    => 'TIMTextElem',
      'MsgContent' => [
        'Text' => 'hi, beauty'
      ]
    ]
  ]
]);
```

`$options` 参数可查看 [Guzzle Request Options](http://guzzle.readthedocs.io/en/latest/request-options.html)

### 3. Response

`TimCloud::request($uri, $body, $options)` 返回为 [`TimSDK\ResponseBag`](https://github.com/JimChenWYU/TimSDK/blob/master/src/Foundation/ResponseBag.php)

```php
// API放回内容
$contents = $response->getContens();
// 获取某个字段, example: {"status": "ok"}
$status = $response->getContent('status');

// API Response Headers
$headers = $response->getHeaders();
// 获取某个返回头部
$encoding = $response->getHeader('Content-Encoding');
```

具体返回JSON实体包查看请到[腾讯云通信官网](https://cloud.tencent.com/document/product/269/1520)