<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/15/2018
 * Time: 3:28 PM
 */

namespace TimSDK\Tests;

use TimSDK\Core\API;
use TimSDK\TimCloud;

class TimCloudTest extends TestCase
{
    public function testEnv()
    {
        $this->assertTrue(phpunit_env('phpunit_running'));
    }

    public function testRefreshConfiguration()
    {
        $timCloud = $this->timCloud();

        $this->assertFalse($timCloud->im->isNeedRefresh());

        $timCloud->setIdentifier('admin');

        $this->assertTrue($timCloud->im->isNeedRefresh());

        $query = $timCloud->im->getQuery();

        $this->assertSame('admin', $query['identifier']);
    }

    public function testFormatKey()
    {
        $timCloud = $this->timCloud();

        $prikey = $timCloud->formatKey(phpunit_env('private_key'), 'private');
        $pubkey = $timCloud->formatKey(phpunit_env('public_key'), 'public');

        $prikeyResource = openssl_pkey_get_private($prikey);
        $pubkeyResource = openssl_pkey_get_public($pubkey);

        $this->assertTrue(is_resource($prikeyResource));
        $this->assertTrue(is_resource($pubkeyResource));
    }

    public function testRequestApi()
    {
        $t = $this->timCloud();
        $c = $t->request(API::DIRTY_WORDS_GET);

        $this->assertSame('OK', $c->get('ActionStatus'));
    }

    public function timCloud()
    {
        return new TimCloud([
            'sdkappid'   => phpunit_env('sdk_appid'),
            'identifier' => phpunit_env('identifier'),
            'prikey'     => phpunit_env('private_key'),
            'pubkey'     => phpunit_env('public_key'),
        ]);
    }
}
