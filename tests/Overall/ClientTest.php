<?php

namespace TimSDK\Tests\Overall;

use TimSDK\Overall\Client;

class ClientTest extends \TimSDK\Tests\TestCase
{
    public function testSetNoSpeaking()
    {
        $client = $this->mockApiClient(Client::class, ['setNoSpeaking'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/openconfigsvr/setnospeaking',
            [
                'Set_Account' => 'user-1',
                'C2CmsgNospeakingTime' => 1,
                'GroupmsgNospeakingTime' => 2,
            ],
            [
                'servicename' => 'openconfigsvr',
                'command' => 'setnospeaking',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->setNoSpeaking('user-1', 1, 2));
    }

    public function testGetNoSpeaking()
    {
        $client = $this->mockApiClient(Client::class, ['getNoSpeaking'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/openconfigsvr/getnospeaking',
            [
                'Get_Account' => 'user-1',
            ],
            [
                'servicename' => 'openconfigsvr',
                'command' => 'getnospeaking',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getNoSpeaking('user-1'));
    }
}
