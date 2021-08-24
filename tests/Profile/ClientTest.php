<?php

namespace TimSDK\Tests\Profile;

use TimSDK\Profile\Client;
use TimSDK\Profile\Profile;
use TimSDK\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testSetPortrait()
    {
        $client = $this->mockApiClient(Client::class, ['setPortrait'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/profile/portrait_set',
            [
                'From_Account' => 'user1',
                'ProfileItem' => [
                    new Profile('hello', '123456'),
                    new Profile('world', '098765'),
                ],
            ],
            [
                'servicename' => 'profile',
                'command' => 'portrait_set',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->setPortrait(
            'user1',
            [
                new Profile('hello', '123456'),
                new Profile('world', '098765'),
            ]
        ));
    }

    public function testGetPortrait()
    {
        $client = $this->mockApiClient(Client::class, ['getPortrait'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/profile/portrait_get',
            [
                'To_Account' => ['user1'],
                'TagList' => [
                    '12345',
                    '67890',
                ],
            ],
            [
                'servicename' => 'profile',
                'command' => 'portrait_get',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getPortrait(
            ['user1'],
            [
                '12345',
                '67890',
            ]
        ));
    }
}
