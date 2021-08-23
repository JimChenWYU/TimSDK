<?php

namespace TimSDK\Tests\Group;

use TimSDK\Group\Client;
use TimSDK\Group\GroupInfo;
use TimSDK\Group\GroupInfoResponseFilter;
use TimSDK\Group\JoinedGroupResponseFilter;
use TimSDK\Group\Member;
use TimSDK\Group\Message;
use TimSDK\Kernel\DataStruct\AndroidInfo;
use TimSDK\Kernel\DataStruct\ApnsInfo;
use TimSDK\Kernel\DataStruct\MsgBody;
use TimSDK\Kernel\DataStruct\MsgContent\TIMTextElem;
use TimSDK\Kernel\DataStruct\OfflinePushInfo;
use TimSDK\Tests\TestCase;

class ClientTest extends TestCase
{
	public function testGetAppGroup()
	{
		$client = $this->mockApiClient(Client::class, ['getAppGroup'], $this->app())->makePartial();
		$client->expects()->httpPostJson(
			'v4/group_open_http_svc/get_appid_group_list',
			[
				'Next' => 0,
				'Limit' => 1000,
				'GroupType' => '',
			],
			[
				'servicename' => 'group_open_http_svc',
				'command'     => 'get_appid_group_list',
			]
		)->andReturn('mock-result');
		$this->assertSame('mock-result', $client->getAppGroup(
			0,
			1000,
			''
		));
	}

	public function testCreateGroup()
	{
		$client = $this->mockApiClient(Client::class, ['createGroup'], $this->app())->makePartial();
		$client->expects()->httpPostJson(
			'v4/group_open_http_svc/create_group',
			[
				'Owner_Account' => 'foobar',
				'Type' => 'Public',
				'Name' => 'TestGroup',
				"Introduction" => "This is group Introduction", // 群简介（选填）
                "Notification" => "This is group Notification", // 群公告（选填）
                "FaceUrl" => "http://this.is.face.url", // 群头像 URL（选填）
                "MaxMemberCount" => 500, // 最大群成员数量（选填）
                "ApplyJoinOption" => "FreeAccess"  // 申请加群处理方式（选填）
			],
			[
				'servicename' => 'group_open_http_svc',
				'command'     => 'create_group',
			]
		)->andReturn('mock-result');
		$this->assertSame('mock-result', $client->createGroup(
			'foobar',
			'Public',
			'TestGroup',
			new GroupInfo(
				'This is group Introduction',
				'This is group Notification',
				'http://this.is.face.url',
				500,
				'FreeAccess'
			)
		));
	}

	public function testGetGroupInfo()
	{
		$client = $this->mockApiClient(Client::class, ['getGroupInfo'], $this->app())->makePartial();
		$client->expects()->httpPostJson(
			'v4/group_open_http_svc/get_group_info',
			[
				'GroupIdList' => [
					"@TGS#1NVTZEAE4",
					"@TGS#1CXTZEAET",
				],
				'ResponseFilter' => [
					'GroupBaseInfoFilter' => [
						"Type",
						"Name",
						"Introduction",
						"Notification",
					],
					'MemberInfoFilter' => [
						"Account", // 成员ID
						"Role",
					],
					'AppDefinedDataFilter_Group' => [
						"GroupTestData1",
						"GroupTestData2",
					],
					'AppDefinedDataFilter_GroupMember' => [
						"MemberDefined2",
						"MemberDefined1",
					],
				],
			],
			[
				'servicename' => 'group_open_http_svc',
				'command'     => 'get_group_info',
			]
		)->andReturn('mock-result');
		$this->assertSame('mock-result', $client->getGroupInfo(
			[
				"@TGS#1NVTZEAE4",
				"@TGS#1CXTZEAET",
			],
			new GroupInfoResponseFilter(
				[
					"Type",
					"Name",
					"Introduction",
					"Notification",
				],
				[
					"Account", // 成员ID
					"Role",
				],
				[
					"GroupTestData1",
					"GroupTestData2",
				],
				[
					"MemberDefined2",
					"MemberDefined1",
				]
			)
		));

		$client->expects()->httpPostJson(
			'v4/group_open_http_svc/get_group_info',
			[
				'GroupIdList' => [
					"@TGS#1NVTZEAE4",
					"@TGS#1CXTZEAET",
				],
			],
			[
				'servicename' => 'group_open_http_svc',
				'command'     => 'get_group_info',
			]
		)->andReturn('mock-result2');
		$this->assertSame('mock-result2', $client->getGroupInfo([
			"@TGS#1NVTZEAE4",
			"@TGS#1CXTZEAET",
		]));
	}

	public function testGetGroupMemberInfo()
	{
		$client = $this->mockApiClient(Client::class, ['getGroupMemberInfo'], $this->app())->makePartial();
		$client->expects()->httpPostJson(
			'v4/group_open_http_svc/get_group_member_info',
			[
				'GroupId' => '@TGS#1NVTZEAE4',
				'Offset' => 0,
				'Limit' => 100,
				'MemberInfoFilter' => ['foo'],
				'MemberRoleFilter' => ['bar'],
				'AppDefinedDataFilter_GroupMember' => ['foobar'],
			],
			[
				'servicename' => 'group_open_http_svc',
				'command'     => 'get_group_member_info',
			]
		)->andReturn('mock-result');
		$this->assertSame('mock-result', $client->getGroupMemberInfo(
			'@TGS#1NVTZEAE4',
			['foo'],
			['bar'],
			['foobar']
		));
	}

	public function testModifyGroupBaseInfo()
	{
		$client = $this->mockApiClient(Client::class, ['modifyGroupBaseInfo'], $this->app())->makePartial();
		$client->expects()->httpPostJson(
			'v4/group_open_http_svc/modify_group_base_info',
			[
				'GroupId' => '@TGS#2J4SZEAEL',
				'Name' => 'NewName',
				'Introduction' => 'NewIntroduction',
				'Notification' => 'NewNotification',
				'FaceUrl' => 'http://this.is.new.face.url',
				'MaxMemberNum' => 500,
				'ApplyJoinOption' => 'NeedPermission',
				'ShutUpAllMember' => 'On',
				'AppDefinedData' => [
					[
						'Key' => 'GroupTestData1',
						'Value' => 'NewData',
					],
					[
						'Key' => 'GroupTestData2',
						'Value' => '',
					],
				],
			],
			[
				'servicename' => 'group_open_http_svc',
				'command'     => 'modify_group_base_info',
			]
		)->andReturn('mock-result');
		$this->assertSame('mock-result', $client->modifyGroupBaseInfo(
			'@TGS#2J4SZEAEL',
			'NewName',
			false,
			[
				[
					'Key' => 'GroupTestData1',
					'Value' => 'NewData',
				],
				[
					'Key' => 'GroupTestData2',
					'Value' => '',
				],
			],
			new GroupInfo(
				'NewIntroduction',
				'NewNotification',
				'http://this.is.new.face.url',
				500,
				'NeedPermission'
			)
		));
	}

	public function testAddGroupMember()
	{
		$client = $this->mockApiClient(Client::class, ['addGroupMember'], $this->app())->makePartial();
		$client->expects()->httpPostJson(
			'v4/group_open_http_svc/add_group_member',
			[
				'GroupId' => '@TGS#2J4SZEAEL',
				'Silence' => 1,
				'MemberList' => [
					[
						'Member_Account' => 'tommy',
					],
					[
						'Member_Account' => 'jared',
					],
				],
			],
			[
				'servicename' => 'group_open_http_svc',
				'command'     => 'add_group_member',
			]
		)->andReturn('mock-result');
		$this->assertSame('mock-result', $client->addGroupMember(
			'@TGS#2J4SZEAEL',
			[
				[
					'Member_Account' => 'tommy',
				],
				[
					'Member_Account' => 'jared',
				],
			],
			true
		));
	}

	public function testDeleteGroupMember()
	{
		$client = $this->mockApiClient(Client::class, ['deleteGroupMember'], $this->app())->makePartial();
		$client->expects()->httpPostJson(
			'v4/group_open_http_svc/delete_group_member',
			[
				'GroupId' => '@TGS#2J4SZEAEL',
				'Silence' => 1,
				'MemberToDel_Account' => [
					'tommy'
				],
			],
			[
				'servicename' => 'group_open_http_svc',
				'command'     => 'delete_group_member',
			]
		)->andReturn('mock-result');
		$this->assertSame('mock-result', $client->deleteGroupMember(
			'@TGS#2J4SZEAEL',
			[
				'tommy'
			],
			true
		));
	}

	public function testModifyGroupMemberInfo()
	{
		$client = $this->mockApiClient(Client::class, ['modifyGroupMemberInfo'], $this->app())->makePartial();
		$client->expects()->httpPostJson(
			'v4/group_open_http_svc/modify_group_member_info',
			[
				'GroupId' => '@TGS#2J4SZEAEL',
				'Member_Account' => 'tommy',
				'Role' => 'Member',
				'MsgFlag' => 'AcceptAndNotify',
				'NameCard' => 'foobar',
				'ShutUpTime' => 100,
				'AppMemberDefinedData' => [
					[
						'Key' => 'MemberDefined1',
						'Value' => 'ModifyData1',
					],
					[
						'Key' => 'MemberDefined3',
						'Value' => 'ModifyData3',
					],
				]
			],
			[
				'servicename' => 'group_open_http_svc',
				'command'     => 'modify_group_member_info',
			]
		)->andReturn('mock-result');
		$this->assertSame('mock-result', $client->modifyGroupMemberInfo(
			'@TGS#2J4SZEAEL',
			'tommy',
			'Member',
			'AcceptAndNotify',
			'foobar',
			100,
			[
				[
					'Key' => 'MemberDefined1',
					'Value' => 'ModifyData1',
				],
				[
					'Key' => 'MemberDefined3',
					'Value' => 'ModifyData3',
				],
			]
		));
	}

	public function testDestroyGroup()
	{
		$client = $this->mockApiClient(Client::class, ['destroyGroup'], $this->app())->makePartial();
		$client->expects()->httpPostJson(
			'v4/group_open_http_svc/destroy_group',
			[
				'GroupId' => '@TGS#2J4SZEAEL',
			],
			[
				'servicename' => 'group_open_http_svc',
				'command'     => 'destroy_group',
			]
		)->andReturn('mock-result');
		$this->assertSame('mock-result', $client->destroyGroup(
			'@TGS#2J4SZEAEL'
		));
	}

	public function testGetJoinedGroupList()
	{
		$client = $this->mockApiClient(Client::class, ['getJoinedGroupList'], $this->app())->makePartial();
		$client->expects()->httpPostJson(
			'v4/group_open_http_svc/get_joined_group_list',
			[
				'Member_Account' => 'foobar',
				'Offset' => 0,
				'Limit'  => 100,
				'GroupType' => 'Public',
				'WithHugeGroups' => 100,
				'WithNoActiveGroups' => 200,
				'ResponseFilter' => new JoinedGroupResponseFilter(
					['foo'],
					['bar']
				),
			],
			[
				'servicename' => 'group_open_http_svc',
				'command'     => 'get_joined_group_list',
			]
		)->andReturn('mock-result');
		$this->assertSame('mock-result', $client->getJoinedGroupList(
			'foobar',
			'Public',
			100,
			200,
			new JoinedGroupResponseFilter(
				['foo'],
				['bar']
			),
			0,
			100
		));
	}

	public function testGetRoleInGroup()
	{
		$client = $this->mockApiClient(Client::class, ['getRoleInGroup'], $this->app())->makePartial();
		$client->expects()->httpPostJson(
			'v4/group_open_http_svc/get_role_in_group',
			[
				'GroupId' => '@TGS#2J4SZEAEL',
				'User_Account' => ['foo']
			],
			[
				'servicename' => 'group_open_http_svc',
				'command'     => 'get_role_in_group',
			]
		)->andReturn('mock-result');
		$this->assertSame('mock-result', $client->getRoleInGroup(
			'@TGS#2J4SZEAEL',
			['foo']
		));
	}

	public function testForbidSendMsg()
	{
		$client = $this->mockApiClient(Client::class, ['forbidSendMsg'], $this->app())->makePartial();
		$client->expects()->httpPostJson(
			'v4/group_open_http_svc/forbid_send_msg',
			[
				'GroupId' => '@TGS#2J4SZEAEL',
				'Members_Account' => ['foo'],
				'ShutUpTime' => 1
			],
			[
				'servicename' => 'group_open_http_svc',
				'command'     => 'forbid_send_msg',
			]
		)->andReturn('mock-result');
		$this->assertSame('mock-result', $client->forbidSendMsg(
			'@TGS#2J4SZEAEL',
			['foo'],
			1
		));
	}

	public function testGetGroupShuttedUin()
	{
		$client = $this->mockApiClient(Client::class, ['getGroupShuttedUin'], $this->app())->makePartial();
		$client->expects()->httpPostJson(
			'v4/group_open_http_svc/get_group_shutted_uin',
			[
				'GroupId' => '@TGS#2J4SZEAEL',
			],
			[
				'servicename' => 'group_open_http_svc',
				'command'     => 'get_group_shutted_uin',
			]
		)->andReturn('mock-result');
		$this->assertSame('mock-result', $client->getGroupShuttedUin(
			'@TGS#2J4SZEAEL'
		));
	}

	public function testSendGroupMsg()
	{
		$client = $this->mockApiClient(Client::class, ['sendGroupMsg'], $this->app())->makePartial();
		$client->expects()->httpPostJson(
			'v4/group_open_http_svc/send_group_msg',
			[
				'GroupId' => '@TGS#2J4SZEAEL',
				'Random'  => 12345,
				'MsgPriority' => 'High',
				'MsgBody' => [
					new MsgBody(
						new TIMTextElem('hello world')
					)
				],
				'OnlineOnlyFlag' => 1,
				'From_Account' => 'foobar',
				'OfflinePushInfo' => new OfflinePushInfo(
					'A',
					'B',
					'C',
					'D',
					new AndroidInfo('a', 'b', 'c'),
					new ApnsInfo('a', 1, 'b', 'c', 'd', 2)
				),
				'ForbidCallbackControl' => ['foo'],
				'SendMsgControl' => ['bar'],
				'CloudCustomData' => 'foobar',
			],
			[
				'servicename' => 'group_open_http_svc',
				'command'     => 'send_group_msg',
			]
		)->andReturn('mock-result');
		$this->assertSame('mock-result', $client->sendGroupMsg(
			'@TGS#2J4SZEAEL',
			12345,
			[
				new MsgBody(
					new TIMTextElem('hello world')
				)
			],
			'High', 'foobar', new OfflinePushInfo(
				'A',
				'B',
				'C',
				'D',
				new AndroidInfo('a', 'b', 'c'),
				new ApnsInfo('a', 1, 'b', 'c', 'd', 2)
			),
			['foo'],
			1,
			['bar'],
			'foobar'
		));
	}

	public function testSendGroupSystemNotification()
	{
		$client = $this->mockApiClient(Client::class, ['sendGroupSystemNotification'], $this->app())->makePartial();
		$client->expects()->httpPostJson(
			'v4/group_open_http_svc/send_group_system_notification',
			[
				'GroupId' => '@TGS#2J4SZEAEL',
				'Content' => 'foobar',
				'ToMembers_Account' => [
					'peter', 'leckie',
				],
			],
			[
				'servicename' => 'group_open_http_svc',
				'command'     => 'send_group_system_notification',
			]
		)->andReturn('mock-result');
		$this->assertSame('mock-result', $client->sendGroupSystemNotification(
			'@TGS#2J4SZEAEL',
			'foobar',
			[
				"peter",
				"leckie",
			]
		));
	}

	public function testChangeGroupOwner()
	{
		$client = $this->mockApiClient(Client::class, ['changeGroupOwner'], $this->app())->makePartial();
		$client->expects()->httpPostJson(
			'v4/group_open_http_svc/change_group_owner',
			[
				'GroupId' => '@TGS#2J4SZEAEL',
				'NewOwner_Account' => 'foo'
			],
			[
				'servicename' => 'group_open_http_svc',
				'command'     => 'change_group_owner',
			]
		)->andReturn('mock-result');
		$this->assertSame('mock-result', $client->changeGroupOwner(
			'@TGS#2J4SZEAEL',
			'foo'
		));
	}

	public function testGroupMsgRecall()
	{
		$client = $this->mockApiClient(Client::class, ['groupMsgRecall'], $this->app())->makePartial();
		$client->expects()->httpPostJson(
			'v4/group_open_http_svc/group_msg_recall',
			[
				'GroupId' => '@TGS#2J4SZEAEL',
				'MsgSeqList' => [
					[
						'MsgSeq' => 100
					]
				]
			],
			[
				'servicename' => 'group_open_http_svc',
				'command'     => 'group_msg_recall',
			]
		)->andReturn('mock-result');
		$this->assertSame('mock-result', $client->groupMsgRecall(
			'@TGS#2J4SZEAEL',
			[
				[
					'MsgSeq' => 100
				]
			]
		));
	}

	public function testImportGroup()
	{
		$now = new \DateTime();
		$client = $this->mockApiClient(Client::class, ['importGroup'], $this->app())->makePartial();
		$client->expects()->httpPostJson(
			'v4/group_open_http_svc/import_group',
			[
				'Type' => 'foo',
				'Name' => 'bar',
				'Owner_Account' => 'foobar',
				'GroupId' => '@TGS#2J4SZEAEL',
				'Introduction' => 'This is group Introduction',
				'Notification' => 'This is group Notification',
				'FaceUrl' => 'http://this.is.face.url',
				'MaxMemberCount' => 500,
				'ApplyJoinOption' => 'FreeAccess',
				'CreateTime' => $now->getTimestamp(),
				'AppDefinedData' => [
					[
						'Key' => 'GroupTestData1',
						'Value' => 'xxxxx',
					],
					[
						'Key' => ' GroupTestData2',
						'Value' => 'abc' . "\0" . '',
					],
				],
			],
			[
				'servicename' => 'group_open_http_svc',
				'command'     => 'import_group',
			]
		)->andReturn('mock-result');
		$this->assertSame('mock-result', $client->importGroup(
			'foo',
			'bar',
			'foobar',
			'@TGS#2J4SZEAEL',
			new GroupInfo(
				'This is group Introduction',
				'This is group Notification',
				'http://this.is.face.url',
				500,
				'FreeAccess'
			),
			[
				[
					'Key' => 'GroupTestData1',
					'Value' => 'xxxxx',
				],
				[
					'Key' => ' GroupTestData2',
					'Value' => 'abc' . "\0" . '',
				],
			],
			$now
		));
	}

	public function testImportGroupMsg()
	{
		$client = $this->mockApiClient(Client::class, ['importGroupMsg'], $this->app())->makePartial();
		$client->expects()->httpPostJson(
			'v4/group_open_http_svc/import_group_msg',
			[
				'GroupId' => '@TGS#2J4SZEAEL',
				'MsgList' => [
					new Message('foobar', 123456, 654321, [
						new MsgBody(new TIMTextElem('foo')),
						new MsgBody(new TIMTextElem('bar')),
					])
				],
			],
			[
				'servicename' => 'group_open_http_svc',
				'command'     => 'import_group_msg',
			]
		)->andReturn('mock-result');
		$this->assertSame('mock-result', $client->importGroupMsg(
			'@TGS#2J4SZEAEL',
			[
				new Message('foobar', 123456, 654321, [
					new MsgBody(new TIMTextElem('foo')),
					new MsgBody(new TIMTextElem('bar')),
				])
			]
		));
	}

	public function testImportGroupMember()
	{
		$client = $this->mockApiClient(Client::class, ['importGroupMember'], $this->app())->makePartial();
		$client->expects()->httpPostJson(
			'v4/group_open_http_svc/import_group_member',
			[
				'GroupId' => '@TGS#2J4SZEAEL',
				'MemberList' => [
					new Member('foo', '', 123456, 100),
					new Member('bar', 'Admin', 123456, 200)
				],
			],
			[
				'servicename' => 'group_open_http_svc',
				'command'     => 'import_group_member',
			]
		)->andReturn('mock-result');
		$this->assertSame('mock-result', $client->importGroupMember(
			'@TGS#2J4SZEAEL',
			[
				new Member('foo', '', 123456, 100),
				new Member('bar', 'Admin', 123456, 200)
			]
		));
	}

	public function testSetUnreadMsgNum()
	{
		$client = $this->mockApiClient(Client::class, ['setUnreadMsgNum'], $this->app())->makePartial();
		$client->expects()->httpPostJson(
			'v4/group_open_http_svc/set_unread_msg_num',
			[
				'GroupId' => '@TGS#2J4SZEAEL',
				'Member_Account' => 'foo',
				'UnreadMsgNum' => 10,
			],
			[
				'servicename' => 'group_open_http_svc',
				'command'     => 'set_unread_msg_num',
			]
		)->andReturn('mock-result');
		$this->assertSame('mock-result', $client->setUnreadMsgNum(
			'@TGS#2J4SZEAEL',
			'foo',
			10
		));
	}

	public function testDeleteGroupMsgBySender()
	{
		$client = $this->mockApiClient(Client::class, ['deleteGroupMsgBySender'], $this->app())->makePartial();
		$client->expects()->httpPostJson(
			'v4/group_open_http_svc/delete_group_msg_by_sender',
			[
				'GroupId' => '@TGS#2J4SZEAEL',
				'Sender_Account' => 'foo',
			],
			[
				'servicename' => 'group_open_http_svc',
				'command'     => 'delete_group_msg_by_sender',
			]
		)->andReturn('mock-result');
		$this->assertSame('mock-result', $client->deleteGroupMsgBySender(
			'@TGS#2J4SZEAEL',
			'foo'
		));
	}

	public function testGroupMsgGetSimple()
	{
		$client = $this->mockApiClient(Client::class, ['groupMsgGetSimple'], $this->app())->makePartial();
		$client->expects()->httpPostJson(
			'v4/group_open_http_svc/group_msg_get_simple',
			[
				'GroupId' => '@TGS#2J4SZEAEL',
				'ReqMsgNumber' => 10,
				'ReqMsgSeq' => 100001
			],
			[
				'servicename' => 'group_open_http_svc',
				'command'     => 'group_msg_get_simple',
			]
		)->andReturn('mock-result');
		$this->assertSame('mock-result', $client->groupMsgGetSimple(
			'@TGS#2J4SZEAEL',
			10,
			100001
		));

		$client->expects()->httpPostJson(
			'v4/group_open_http_svc/group_msg_get_simple',
			[
				'GroupId' => '@TGS#2J4SZEAEL',
				'ReqMsgNumber' => 10,
			],
			[
				'servicename' => 'group_open_http_svc',
				'command'     => 'group_msg_get_simple',
			]
		)->andReturn('mock-result');
		$this->assertSame('mock-result', $client->groupMsgGetSimple(
			'@TGS#2J4SZEAEL',
			10
		));
	}

	public function testGetOnlineMemberNum()
	{
		$client = $this->mockApiClient(Client::class, ['getOnlineMemberNum'], $this->app())->makePartial();
		$client->expects()->httpPostJson(
			'v4/group_open_http_svc/get_online_member_num',
			[
				'GroupId' => '@TGS#2J4SZEAEL',
			],
			[
				'servicename' => 'group_open_http_svc',
				'command'     => 'get_online_member_num',
			]
		)->andReturn('mock-result');
		$this->assertSame('mock-result', $client->getOnlineMemberNum(
			'@TGS#2J4SZEAEL'
		));
	}
}
