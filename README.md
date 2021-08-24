<h1 style="text-align: center;">TimSDK</h1>

<p align="center">
<a href="https://www.travis-ci.org/JimChenWYU/TimSDK" rel="nofollow"><img src="https://camo.githubusercontent.com/63c6940ce8f382f537b25800d5026c491b57dd3d/68747470733a2f2f7777772e7472617669732d63692e6f72672f4a696d4368656e5759552f54696d53444b2e7376673f6272616e63683d6d6173746572" alt="Build Status" data-canonical-src="https://www.travis-ci.org/JimChenWYU/TimSDK.svg?branch=master" style="max-width:100%;"></a>
<a href="https://packagist.org/packages/jimchen/tim-sdk" rel="nofollow"><img src="https://camo.githubusercontent.com/ea1f19327483b367e1e93bd318c9b9caf9f13139/68747470733a2f2f706f7365722e707567782e6f72672f6a696d6368656e2f74696d2d73646b2f762f737461626c65" alt="Latest Stable Version" data-canonical-src="https://poser.pugx.org/jimchen/tim-sdk/v/stable" style="max-width:100%;"></a>
<a href="https://packagist.org/packages/jimchen/tim-sdk" rel="nofollow"><img src="https://camo.githubusercontent.com/f3d12412f881aac60bde3252f7964825bfe6d167/68747470733a2f2f706f7365722e707567782e6f72672f6a696d6368656e2f74696d2d73646b2f762f756e737461626c65" alt="Latest Unstable Version" data-canonical-src="https://poser.pugx.org/jimchen/tim-sdk/v/unstable" style="max-width:100%;"></a>
<a href="https://scrutinizer-ci.com/g/JimChenWYU/TimSDK/build-status/master" rel="nofollow"><img src="https://camo.githubusercontent.com/1bb1eae0bea84eff9b5910babac8ae3552a2c6b1/68747470733a2f2f7363727574696e697a65722d63692e636f6d2f672f4a696d4368656e5759552f54696d53444b2f6261646765732f6275696c642e706e673f623d6d6173746572" alt="Build Status" data-canonical-src="https://scrutinizer-ci.com/g/JimChenWYU/TimSDK/badges/build.png?b=master" style="max-width:100%;"></a>
<a href="https://scrutinizer-ci.com/g/JimChenWYU/TimSDK/?branch=master" rel="nofollow"><img src="https://camo.githubusercontent.com/e0c9bca3488e164e280382196c581f3a323e6e7e/68747470733a2f2f7363727574696e697a65722d63692e636f6d2f672f4a696d4368656e5759552f54696d53444b2f6261646765732f7175616c6974792d73636f72652e706e673f623d6d6173746572" alt="Scrutinizer Code Quality" data-canonical-src="https://scrutinizer-ci.com/g/JimChenWYU/TimSDK/badges/quality-score.png?b=master" style="max-width:100%;"></a>
<a href="https://scrutinizer-ci.com/g/JimChenWYU/TimSDK/?branch=master" rel="nofollow"><img src="https://camo.githubusercontent.com/0368ff6833f77df1290ea480ceb5782512143f35/68747470733a2f2f7363727574696e697a65722d63692e636f6d2f672f4a696d4368656e5759552f54696d53444b2f6261646765732f636f7665726167652e706e673f623d6d6173746572" alt="Code Coverage" data-canonical-src="https://scrutinizer-ci.com/g/JimChenWYU/TimSDK/badges/coverage.png?b=master" style="max-width:100%;"></a>
<a href="https://packagist.org/packages/jimchen/tim-sdk" rel="nofollow"><img src="https://camo.githubusercontent.com/eaa8a119d7d3924647f6ae489d26b8d72c37be06/68747470733a2f2f706f7365722e707567782e6f72672f6a696d6368656e2f74696d2d73646b2f646f776e6c6f616473" alt="Total Downloads" data-canonical-src="https://poser.pugx.org/jimchen/tim-sdk/downloads" style="max-width:100%;"></a>
<a href="https://packagist.org/packages/jimchen/tim-sdk" rel="nofollow"><img src="https://camo.githubusercontent.com/21b44103a3e2b4340924b6f18c01607d1cac930d/68747470733a2f2f706f7365722e707567782e6f72672f6a696d6368656e2f74696d2d73646b2f6c6963656e7365" alt="License" data-canonical-src="https://poser.pugx.org/jimchen/tim-sdk/license" style="max-width:100%;"></a>
</p> 

<p align="center">
IM Sdk for Tencent Instant Messaging.
</p>

## Requirement

1. PHP >= 7.2
2. **[Composer](https://getcomposer.org/)**
3. Openssl Extension, Curl Extension

## Installation

```bash
$ composer require "jimchen/tim-sdk:^2.0"
```

## Usage
Basic Usage:

```php
use TimSDK;

$options = [
  'app_id'      => '14000xxxx',
  'identifier'  => 'admin',
  'key' => 'Your key',
  'http'        => [
	'timeout'  => 30,
  ],
];
$app = new TimSDK\Application($options);
$collect = $app->account->import('identifier', 'nickname', 'faceUrl');
```

## Documentation

- [Tencent Tim](https://cloud.tencent.com/document/product/269/1519)

## License

[MIT](https://opensource.org/licenses/MIT/)
