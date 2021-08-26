<?php

namespace TimSDK\Tests\MemberPush;

use TimSDK\Kernel\DataStruct\MsgBody;
use TimSDK\Kernel\DataStruct\MsgContent\TIMTextElem;
use TimSDK\MemberPush\Client;
use TimSDK\MemberPush\UserAttr;
use TimSDK\MemberPush\UserTag;
use TimSDK\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testPushAllMember()
    {
        $client = $this->mockApiClient(Client::class, ['pushAllMember'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/all_member_push/im_push',
            [
                'From_Account' => 'user-1',
                'MsgRandom' => 123456,
                'MsgBody' => [
                    new MsgBody(new TIMTextElem('hi, foo'))
                ],
            ],
            [
                'servicename' => 'all_member_push',
                'command' => 'im_push',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->pushAllMember('user-1', 123456, [
            new MsgBody(new TIMTextElem('hi, foo'))
        ]));
    }

    public function testSetAppAttr()
    {
        $client = $this->mockApiClient(Client::class, ['setAppAttr'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/all_member_push/im_set_attr_name',
            [
                'AttrNames' => [
                    '0' => 'sex',
                    '1' => 'city',
                    '2' => 'country',
                ],
            ],
            [
                'servicename' => 'all_member_push',
                'command' => 'im_set_attr_name',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->setAppAttr([
            '0' => 'sex',
            '1' => 'city',
            '2' => 'country',
        ]));
    }

    public function testGetAppAttr()
    {
        $client = $this->mockApiClient(Client::class, ['getAppAttr'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/all_member_push/im_get_attr_name',
            [],
            [
                'servicename' => 'all_member_push',
                'command' => 'im_get_attr_name',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getAppAttr());
    }

    public function testGetUserAttr()
    {
        $client = $this->mockApiClient(Client::class, ['removeUserAttr'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/all_member_push/im_get_attr',
            [
                'To_Account' => ['user1', 'user2']
            ],
            [
                'servicename' => 'all_member_push',
                'command' => 'im_get_attr',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getUserAttr(['user1', 'user2']));
    }

    public function testSetUserAttr()
    {
        $client = $this->mockApiClient(Client::class, ['setUserAttr'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/all_member_push/im_set_attr',
            [
                'UserAttrs' => [
                    new UserAttr('user1', [
                        'sex' => 'attr1',
                        'city' => 'attr2',
                    ])
                ]
            ],
            [
                'servicename' => 'all_member_push',
                'command' => 'im_set_attr',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->setUserAttr([
            new UserAttr('user1', [
                'sex' => 'attr1',
                'city' => 'attr2',
            ])
        ]));
    }

    public function testRemoveUserAttr()
    {
        $client = $this->mockApiClient(Client::class, ['removeUserAttr'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/all_member_push/im_remove_attr',
            [
                'UserAttrs' => [
                    new UserAttr('user1', [
                        'sex' => 'attr1',
                        'city' => 'attr2',
                    ])
                ]
            ],
            [
                'servicename' => 'all_member_push',
                'command' => 'im_remove_attr',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->removeUserAttr([
            new UserAttr('user1', [
                'sex' => 'attr1',
                'city' => 'attr2',
            ])
        ]));
    }

    public function testGetTag()
    {
        $client = $this->mockApiClient(Client::class, ['getTag'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/all_member_push/im_get_tag',
            [
                'To_Account' => [
                    'user1',
                    'user2',
                ]
            ],
            [
                'servicename' => 'all_member_push',
                'command' => 'im_get_tag',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getTag([
            'user1',
            'user2',
        ]));
    }

    public function testAddTag()
    {
        $client = $this->mockApiClient(Client::class, ['addTag'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/all_member_push/im_add_tag',
            [
                'UserTags' => [
                    new UserTag('user1', [
                        'hello', 'world',
                    ])
                ]
            ],
            [
                'servicename' => 'all_member_push',
                'command' => 'im_add_tag',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->addTag([
            new UserTag('user1', [
                'hello', 'world',
            ])
        ]));
    }

    public function testRemoveTag()
    {
        $client = $this->mockApiClient(Client::class, ['removeTag'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/all_member_push/im_remove_tag',
            [
                'UserTags' => [
                    new UserTag('user1', [
                        'hello', 'world',
                    ])
                ]
            ],
            [
                'servicename' => 'all_member_push',
                'command' => 'im_remove_tag',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->removeTag([
            new UserTag('user1', [
                'hello', 'world',
            ])
        ]));
    }

    public function testRemoveAllTags()
    {
        $client = $this->mockApiClient(Client::class, ['removeAllTags'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/all_member_push/im_remove_all_tags',
            [
                'To_Account' => [
                    'user1', 'user2',
                ]
            ],
            [
                'servicename' => 'all_member_push',
                'command' => 'im_remove_all_tags',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->removeAllTags([
            'user1', 'user2',
        ]));
    }
}
