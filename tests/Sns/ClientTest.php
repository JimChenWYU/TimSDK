<?php

namespace TimSDK\Tests\Sns;

use TimSDK\Sns\Client;
use TimSDK\Sns\Friend;
use TimSDK\Sns\UpdateFriend;
use TimSDK\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testAddFriend()
    {
        $client = $this->mockApiClient(Client::class, ['addFriend'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/sns/friend_add',
            [
                'From_Account' => 'user1',
                'AddFriendItem' => [
                    new Friend('user2', 'foo'),
                ],
            ],
            [
                'servicename' => 'sns',
                'command' => 'friend_add',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->addFriend(
            'user1',
            [
                new Friend('user2', 'foo'),
            ]
        ));
    }

    public function testImportFriend()
    {
        $client = $this->mockApiClient(Client::class, ['importFriend'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/sns/friend_import',
            [
                'From_Account' => 'user1',
                'AddFriendItem' => [
                    new Friend('user2', 'foo'),
                ],
            ],
            [
                'servicename' => 'sns',
                'command' => 'friend_import',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->importFriend(
            'user1',
            [
                new Friend('user2', 'foo'),
            ]
        ));
    }

    public function testUpdateFriend()
    {
        $client = $this->mockApiClient(Client::class, ['updateFriend'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/sns/friend_update',
            [
                'From_Account' => 'user1',
                'UpdateItem' => [
                    new UpdateFriend('user2', [
                        [
                            'Tag' => 'Tag_SNS_IM_Remark',
                            'Value' => 'remark1'
                        ]
                    ]),
                ],
            ],
            [
                'servicename' => 'sns',
                'command' => 'friend_update',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->updateFriend(
            'user1',
            [
                new UpdateFriend('user2', [
                    [
                        'Tag' => 'Tag_SNS_IM_Remark',
                        'Value' => 'remark1'
                    ]
                ]),
            ]
        ));
    }

    public function testDeleteFriend()
    {
        $client = $this->mockApiClient(Client::class, ['deleteFriend'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/sns/friend_delete',
            [
                'From_Account' => 'user1',
                'To_Account' => ['user2'],
                'DeleteType' => 'Delete_Type_Both'
            ],
            [
                'servicename' => 'sns',
                'command' => 'friend_delete',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->deleteFriend(
            'user1',
            ['user2'],
            true
        ));
    }

    public function testDeleteAllFriend()
    {
        $client = $this->mockApiClient(Client::class, ['deleteAllFriend'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/sns/friend_delete_all',
            [
                'From_Account' => 'user1',
            ],
            [
                'servicename' => 'sns',
                'command' => 'friend_delete_all',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->deleteAllFriend(
            'user1'
        ));
    }

    public function testCheckFriend()
    {
        $client = $this->mockApiClient(Client::class, ['checkFriend'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/sns/friend_check',
            [
                'From_Account' => 'user1',
                'To_Account' => ['user2'],
                'CheckType' => 'CheckResult_Type_Both',
            ],
            [
                'servicename' => 'sns',
                'command' => 'friend_check',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->checkFriend(
            'user1',
            ['user2'],
            true
        ));
    }

    public function testGetFriendList()
    {
        $client = $this->mockApiClient(Client::class, ['getFriendList'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/sns/friend_get_list',
            [
                'From_Account' => 'user1',
                'To_Account' => ['user2'],
                'TagList' => [
                    'foo',
                    'bar',
                ],
            ],
            [
                'servicename' => 'sns',
                'command' => 'friend_get_list',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getFriendList(
            'user1',
            ['user2'],
            ['foo', 'bar',]
        ));
    }

    public function testAddBlacklist()
    {
        $client = $this->mockApiClient(Client::class, ['addBlacklist'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/sns/black_list_add',
            [
                'From_Account' => 'user1',
                'To_Account' => ['user2'],
            ],
            [
                'servicename' => 'sns',
                'command' => 'black_list_add',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->addBlacklist(
            'user1',
            ['user2']
        ));
    }

    public function testDeleteBlacklist()
    {
        $client = $this->mockApiClient(Client::class, ['deleteBlacklist'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/sns/black_list_delete',
            [
                'From_Account' => 'user1',
                'To_Account' => ['user2'],
            ],
            [
                'servicename' => 'sns',
                'command' => 'black_list_delete',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->deleteBlacklist(
            'user1',
            ['user2']
        ));
    }

    public function testCheckBlacklist()
    {
        $client = $this->mockApiClient(Client::class, ['checkBlacklist'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/sns/black_list_check',
            [
                'From_Account' => 'user1',
                'To_Account' => ['user2'],
                'CheckType' => 'BlackCheckResult_Type_Both'
            ],
            [
                'servicename' => 'sns',
                'command' => 'black_list_check',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->checkBlacklist(
            'user1',
            ['user2'],
            true
        ));
    }

    public function testAddGroup()
    {
        $client = $this->mockApiClient(Client::class, ['addGroup'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/sns/group_add',
            [
                'From_Account' => 'user1',
                'GroupName' => ['group1', 'group2'],
                'To_Account' => ['user2'],
            ],
            [
                'servicename' => 'sns',
                'command' => 'group_add',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->addGroup(
            'user1',
            ['group1', 'group2'],
            ['user2']
        ));
    }

    public function testDeleteGroup()
    {
        $client = $this->mockApiClient(Client::class, ['deleteGroup'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/sns/group_delete',
            [
                'From_Account' => 'user1',
                'GroupName' => ['group1', 'group2'],
            ],
            [
                'servicename' => 'sns',
                'command' => 'group_delete',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->deleteGroup(
            'user1',
            ['group1', 'group2']
        ));
    }

    public function testGetGroup()
    {
        $client = $this->mockApiClient(Client::class, ['getGroup'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/sns/group_get',
            [
                'From_Account' => 'user1',
                'LastSequence' => 1,
                'NeedFriend' => '',
                'GroupName' => [],
            ],
            [
                'servicename' => 'sns',
                'command' => 'group_get',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getGroup(
            'user1',
            1
        ));
    }
}
