<?php

namespace TimSDK\Tests\Account;

use TimSDK\Account\Client;
use TimSDK\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testImport()
    {
        $client = $this->mockApiClient(Client::class, ['import'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/im_open_login_svc/account_import',
            [
                'Identifier' => 'user-1',
                'Nick' => 'nick-1',
                'FaceUrl' => 'url-1',
            ],
            [
                'servicename' => 'im_open_login_svc',
                'command' => 'account_import',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->import('user-1', 'nick-1', 'url-1'));
    }

    public function testMultiImport()
    {
        $client = $this->mockApiClient(Client::class, ['multiImport'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/im_open_login_svc/multiaccount_import',
            [
                'Accounts' => [
                    'user-1', 'user-2', 'user-3'
                ]
            ],
            [
                'servicename' => 'im_open_login_svc',
                'command' => 'multiaccount_import',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->multiImport([
            'user-1', 'user-2', 'user-3'
        ]));
    }

    public function testDelete()
    {
        $client = $this->mockApiClient(Client::class, ['delete'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/im_open_login_svc/account_delete',
            [
                'DeleteItem' => [
                    ['UserID' => 'user-1'],
                    ['UserID' => 'user-2'],
                ]
            ],
            [
                'servicename' => 'im_open_login_svc',
                'command' => 'account_delete',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->delete([
            ['UserID' => 'user-1'],
            ['UserID' => 'user-2'],
        ]));
    }

    public function testCheckAccount()
    {
        $client = $this->mockApiClient(Client::class, ['checkAccount'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/im_open_login_svc/account_check',
            [
                'CheckItem' => [
                    ['UserID' => 'user-1'],
                    ['UserID' => 'user-2'],
                ]
            ],
            [
                'servicename' => 'im_open_login_svc',
                'command' => 'account_check',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->checkAccount([
            ['UserID' => 'user-1'],
            ['UserID' => 'user-2'],
        ]));
    }

    public function testKick()
    {
        $client = $this->mockApiClient(Client::class, ['kick'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/im_open_login_svc/kick',
            [
                'Identifier' => 'user-1'
            ],
            [
                'servicename' => 'im_open_login_svc',
                'command' => 'kick',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->kick('user-1'));
    }

    public function testQueryState()
    {
        $client = $this->mockApiClient(Client::class, ['queryState'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/openim/query_online_status',
            [
                'To_Account' => ['user-1', 'user-2']
            ],
            [
                'servicename' => 'openim',
                'command' => 'query_online_status',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->queryState(['user-1', 'user-2']));
    }
}
