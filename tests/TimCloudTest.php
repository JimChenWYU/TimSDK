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
use TimSDK\Core\IMCloud;
use TimSDK\Foundation\ResponseBag;
use TimSDK\TimCloud;

class TimCloudTest extends TestCase
{
    public function testEnv()
    {
        $this->assertTrue(phpunit_env('phpunit_running'));
    }

    public function testGetVersion()
    {
        $timCloud = $this->timCloud();

        $this->assertSame(TimCloud::VERSION, $timCloud->version());
    }
    
    public function testCertPemExist()
    {
        $t = $this->timCloud();

        $this->assertTrue(file_exists($t['path.cert'] . '/cacert.pem'));
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

    public function testSetter()
    {
        $timCloud = $this->timCloud();

        $timCloud->setAppId('1404xxxxx');
        $timCloud->setIdentifier('TimSDK');
        $timCloud->setPublicKey('public_key_xxxxxx');
        $timCloud->setPrivateKey('private_key_xxxxxx');
        $query = $timCloud->im->getLatestQueryString();

        $this->assertSame('1404xxxxx', $query['app_id']);
        $this->assertSame('TimSDK', $query['identifier']);
        $this->assertSame('-----BEGIN PRIVATE KEY-----
private_key_xxxxxx
-----END PRIVATE KEY-----', $query['private_key']);
        $this->assertSame('-----BEGIN PUBLIC KEY-----
public_key_xxxxxx
-----END PUBLIC KEY-----', $query['public_key']);
    }

    public function testRefreshConfiguration()
    {
        $timCloud = $this->timCloud();
        $this->assertFalse($timCloud->im->isNeedRefresh());

        $timCloud->setIdentifier('admin');
        $this->assertTrue($timCloud->im->isNeedRefresh());

        $query = $timCloud->im->getLatestQueryString();
        $this->assertSame('admin', $query['identifier']);
        $this->assertFalse($timCloud->im->isNeedRefresh());

        $timCloud->setAppId('1404xxxxx');
        $timCloud->setIdentifier('common_user');
        $timCloud->setPublicKey('public_key_xxxxxx');
        $timCloud->setPrivateKey('private_key_xxxxxx');
        $query = $timCloud->im->getLatestQueryString();

        $this->assertSame([
            'sdkappid'    => '1404xxxxx',
            'identifier'  => 'common_user',
            'contenttype' => 'json',
        ], $timCloud->im->getLatestQueryString([
            'sdkappid',
            'identifier',
            'contenttype',
        ]));
        $this->assertArrayHasKey('random', $timCloud->im->getLatestQueryString());
        $this->assertArrayHasKey('usersig', $timCloud->im->getLatestQueryString());
        $this->assertSame('-----BEGIN PRIVATE KEY-----
private_key_xxxxxx
-----END PRIVATE KEY-----', $query['private_key']);
        $this->assertSame('-----BEGIN PUBLIC KEY-----
public_key_xxxxxx
-----END PUBLIC KEY-----', $query['public_key']);
    }

    /**
     * @expectedException \TimSDK\Core\Exceptions\MissingArgumentsException
     * @expectedExceptionMessage Missing app_id.
     */
    public function testMissAppId()
    {
        $timCloud = new TimCloud([
            'identifier'  => phpunit_env('identifier', 'common_user'),
            'private_key' => phpunit_env('private_key', 'openssl_private_key'),
            'public_key'  => phpunit_env('public_key', 'openssl_public_key'),
        ]);

        $timCloud['im'];
    }

    /**
     * @expectedException \TimSDK\Core\Exceptions\MissingArgumentsException
     * @expectedExceptionMessage Missing identifier.
     */
    public function testMissIdentifier()
    {
        $timCloud = new TimCloud([
            'app_id'      => phpunit_env('app_id', '1400xxxxxx'),
            'private_key' => phpunit_env('private_key', 'openssl_private_key'),
            'public_key'  => phpunit_env('public_key', 'openssl_public_key'),
        ]);

        $timCloud['im'];
    }

    /**
     * @expectedException \TimSDK\Core\Exceptions\MissingArgumentsException
     * @expectedExceptionMessage Missing private_key.
     */
    public function testMissPrivateKey()
    {
        $timCloud = new TimCloud([
            'app_id'      => phpunit_env('app_id', '1400xxxxxx'),
            'identifier'  => phpunit_env('identifier', 'common_user'),
            'public_key'  => phpunit_env('public_key', 'openssl_public_key'),
        ]);

        $timCloud['im'];
    }

    /**
     * @expectedException \TimSDK\Core\Exceptions\MissingArgumentsException
     * @expectedExceptionMessage Missing public_key.
     */
    public function testMissPublicKey()
    {
        $timCloud = new TimCloud([
            'app_id'      => phpunit_env('app_id', '1400xxxxxx'),
            'identifier'  => phpunit_env('identifier', 'common_user'),
            'private_key' => phpunit_env('private_key', 'openssl_private_key'),
        ]);

        $timCloud['im'];
    }

    public function testRequestApiSuccess()
    {
        $t = $this->timCloud();
        $t->offsetSet('im', function () {
            $m = Mockery::mock('im');
            $m->shouldReceive('handle')->withAnyArgs()->andReturn(new ResponseBag([
                'ActionStatus' => 'OK',
            ], [
                'content-type' => 'application/json',
            ]));

            return $m;
        });

        $c = $t->request(API::DIRTY_WORDS_GET);
        $this->assertSame('OK', $c->getContent('ActionStatus'));
    }

    /**
     * @expectedException \TimSDK\Core\Exceptions\HttpException
     * @expectedExceptionMessage HTTP Parse Error.
     */
    public function testRequestApiError()
    {
        $t = $this->timCloud([
            'im' => function () {
                $m = Mockery::mock(IMCloud::class);
                $return = new ResponseBag([
                    'ErrorCode' => 80002,
                    'ErrorInfo' => 'HTTP Parse Error.',
                ], [
                    'content-type' => 'application/json',
                ]);

                $m->shouldAllowMockingMethod('handle')->shouldDeferMissing();

                $m->shouldReceive('getLatestQueryString')->withAnyArgs()->andReturn([]);
                $m->shouldReceive('httpPostJson')->withAnyArgs()->andReturn($return);

                return $m;
            },
        ]);

        $t->request(API::DIRTY_WORDS_GET);
    }

    public function timCloud($prepends = [])
    {
        return new TimCloud([
            'app_id'      => phpunit_env('app_id', '1400xxxxxx'),
            'identifier'  => phpunit_env('identifier', 'common_user'),
            'private_key' => phpunit_env('private_key', 'openssl_private_key'),
            'public_key'  => phpunit_env('public_key', 'openssl_public_key'),
        ], array_merge([
            'TLSSig' => function () {
                $m = Mockery::mock('TLSSig');
                $m->shouldReceive('genSig')->withAnyArgs()->andReturn('test usersig');
                return $m;
            },
        ], $prepends));
    }
}
