<?php

namespace TimSDK\Tests\Operate;

use TimSDK\Operate\Client;
use TimSDK\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testGetAppInfo()
    {
        $client = $this->mockApiClient(Client::class, ['getAppInfo'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/openconfigsvr/getappinfo',
            [
                'RequestField' => ['user-1'],
            ],
            [
                'servicename' => 'openconfigsvr',
                'command' => 'getappinfo',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getAppInfo(['user-1']));
    }

    public function testGetHistory()
    {
        $client = $this->mockApiClient(Client::class, ['getHistory'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/open_msg_svc/get_history',
            [
                'ChatType' => 'C2C',
                'MsgTime' => '2021082317'
            ],
            [
                'servicename' => 'open_msg_svc',
                'command' => 'get_history',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getHistory('C2C', '2021082317'));
    }

    public function testGetIpList()
    {
        $client = $this->mockApiClient(Client::class, ['getIpList'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/ConfigSvc/GetIPList',
            [
            ],
            [
                'servicename' => 'ConfigSvc',
                'command' => 'GetIPList',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getIpList());
    }
}
