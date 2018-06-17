<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/15/2018
 * Time: 3:28 PM
 */

namespace TimSDK\Tests;

use Mockery;
use TimSDK\Core\API;
use TimSDK\Foundation\ResponseBag;
use TimSDK\TimCloud;

class TimCloudTest extends TestCase
{
    public function testEnv()
    {
        $this->assertTrue(phpunit_env('phpunit_running'));
    }

    public function testCertPemExist()
    {
        $t = $this->timCloud();

        $this->assertTrue(file_exists($t['path.cert'] . '/cacert.pem'));
    }

    public function testRefreshConfiguration()
    {
        $timCloud = $this->timCloud();

        $this->assertFalse($timCloud->im->isNeedRefresh());

        $timCloud->setIdentifier('admin');

        $this->assertTrue($timCloud->im->isNeedRefresh());

        $query = $timCloud->im->getRefreshedQueryStringArray();

        $this->assertSame('admin', $query['identifier']);
    }

    public function testFormatKey()
    {
        $timCloud = $this->timCloud();

        $priKeyContent = 'MIGqAgEAAiEAsHYdyE9VvL9gwVBXVQrUFSWiWRTD+A+bgyMizSN8uqcCAwEAAQIg
B1LfqZChXlQTD/LlrQHmC2j+E5Fm1+55V/AcT39xGgECEQDauiGoffbvSGVcMPej
Qy+5AhEAzogp60smRdoK0RYDE76tXwIRAMl/xbgqa02fHTmkJs6x+4kCEEouJ/hG
FqoSJb5xjItj+jsCEBxm38VmLmQgIHwKP3ids9U=';
        $pubKeyContent = 'MDwwDQYJKoZIhvcNAQEBBQADKwAwKAIhALB2HchPVby/YMFQV1UK1BUlolkUw/gP
m4MjIs0jfLqnAgMBAAE=';

        $openSSLPrivateKey = "-----BEGIN PRIVATE KEY-----
$priKeyContent
-----END PRIVATE KEY-----";
        $openSSLPublicKey = "-----BEGIN PUBLIC KEY-----
$pubKeyContent
-----END PUBLIC KEY-----";

        $prikey1 = $timCloud->formatKey($priKeyContent, 'private');
        $pubkey1 = $timCloud->formatKey($pubKeyContent, 'public');

        $prikey2 = $timCloud->formatKey($openSSLPrivateKey, 'private');
        $pubkey2 = $timCloud->formatKey($openSSLPublicKey, 'public');

        $this->assertSame($openSSLPrivateKey, $prikey1);
        $this->assertSame($openSSLPublicKey, $pubkey1);
        $this->assertSame($openSSLPrivateKey, $prikey2);
        $this->assertSame($openSSLPublicKey, $pubkey2);
    }

    public function testRequestApi()
    {
        $t = $this->timCloud();
        $t->offsetSet('im', function ()  {
            $m = Mockery::mock('im');
            $m->shouldReceive('handle')->withAnyArgs()->andReturn(new ResponseBag([
                'ActionStatus' => 'OK'
            ], [
                'content-type' => 'application/json'
            ]));
            return $m;
        });

        $c = $t->request(API::DIRTY_WORDS_GET);
        $this->assertSame('OK', $c->getContent('ActionStatus'));
    }

    public function timCloud()
    {
        return new TimCloud([
            'sdkappid'   => phpunit_env('sdk_appid', '1400xxxxxx'),
            'identifier' => phpunit_env('identifier', 'common_user'),
            'prikey'     => phpunit_env('private_key', 'openssl_private_key'),
            'pubkey'     => phpunit_env('public_key', 'openssl_public_key'),
        ], [
            'TLSSig' => function () {
                $m = Mockery::mock('TLSSig');
                $m->shouldReceive('genSig')->withAnyArgs()->andReturn('test usersig');
                return $m;
            },
        ]);
    }

    public function tearDown()
    {
        Mockery::close();
    }
}
