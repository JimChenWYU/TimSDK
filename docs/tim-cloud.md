## TimCloud

### 1. Configuration Parameters Reset

You can reset `app_id`, `identifier`, `private_key`, `public_key`

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
`$uri` should view [here](https://github.com/JimChenWYU/TimSDK/blob/master/src/Core/API.php)

`$body` is a request entity，for [more](https://cloud.tencent.com/document/product/269/1520)

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

`$options` is same with [Guzzle Request Options](http://guzzle.readthedocs.io/en/latest/request-options.html)

### 3. Response

`TimCloud::request($uri, $body, $options)` return [`TimSDK\ResponseBag`](https://github.com/JimChenWYU/TimSDK/blob/master/src/Foundation/ResponseBag.php)

```php
// API response contents
$contents = $response->getContens();
// get a field by key, example: {"status": "ok"}
$status = $response->getContent('status');

// API Response Headers
$headers = $response->getHeaders();
// get a header by name
$encoding = $response->getHeader('Content-Encoding');
```
What about the JSON Data Structure, view this [official website]((https://cloud.tencent.com/document/product/269/1520)) for more