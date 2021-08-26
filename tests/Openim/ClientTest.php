<?php

namespace TimSDK\Tests\Openim;

use TimSDK\Openim\Client;
use TimSDK\Openim\Dto\BatchSendMsgDto;
use TimSDK\Openim\Dto\SendMsgDto;
use TimSDK\Kernel\DataStruct\MsgBody;
use TimSDK\Kernel\DataStruct\MsgContent\TIMTextElem;
use TimSDK\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testSendMsg()
    {
        $client = $this->mockApiClient(Client::class, ['sendMsg'], $this->app())->makePartial();
        $dto = new SendMsgDto(
            2,
            'lumotuwe2',
            60,
            93847636,
            1287657,
            1557387418,
            [
                new MsgBody(new TIMTextElem('hi, beauty'))
            ],
            'your cloud custom data'
        );
        $client->expects()->httpPostJson(
            'v4/openim/sendmsg',
            [
                'SyncOtherMachine' => $dto->getSyncOtherMachine(),
                'To_Account' => $dto->getToAccount(),
                'MsgLifeTime' => $dto->getMsgLifeTime(),
                'MsgSeq' => $dto->getMsgSeq(),
                'MsgRandom' => $dto->getMsgRandom(),
                'MsgTimeStamp' => $dto->getMsgTimeStamp(),
                'MsgBody' => $dto->getMsgBody(),
                'CloudCustomData' => $dto->getCloudCustomData(),
            ],
            [
                'servicename' => 'openim',
                'command' => 'sendmsg',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->sendMsg($dto));
    }

    public function testBatchSendMsg()
    {
        $client = $this->mockApiClient(Client::class, ['batchSendMsg'], $this->app())->makePartial();
        $dto = new BatchSendMsgDto(
            2,
            ['lumotuwe1', 'lumotuwe2'],
            60,
            93847636,
            1287657,
            1557387418,
            [
                new MsgBody(new TIMTextElem('hi, beauty'))
            ],
            'your cloud custom data'
        );
        $client->expects()->httpPostJson(
            'v4/openim/batchsendmsg',
            [
                'SyncOtherMachine' => $dto->getSyncOtherMachine(),
                'To_Account' => $dto->getToAccount(),
                'MsgLifeTime' => $dto->getMsgLifeTime(),
                'MsgSeq' => $dto->getMsgSeq(),
                'MsgRandom' => $dto->getMsgRandom(),
                'MsgTimeStamp' => $dto->getMsgTimeStamp(),
                'MsgBody' => $dto->getMsgBody(),
                'CloudCustomData' => $dto->getCloudCustomData(),
            ],
            [
                'servicename' => 'openim',
                'command' => 'batchsendmsg',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->batchSendMsg($dto));
    }

    public function testImportMsg()
    {
        $client = $this->mockApiClient(Client::class, ['importMsg'], $this->app())->makePartial();
        $dto = new SendMsgDto(
            2,
            'lumotuwe2',
            60,
            93847636,
            1287657,
            1557387418,
            [
                new MsgBody(new TIMTextElem('hi, beauty'))
            ],
            'your cloud custom data'
        );
        $client->expects()->httpPostJson(
            'v4/openim/importmsg',
            [
                'SyncOtherMachine' => $dto->getSyncOtherMachine(),
                'To_Account' => $dto->getToAccount(),
                'MsgLifeTime' => $dto->getMsgLifeTime(),
                'MsgSeq' => $dto->getMsgSeq(),
                'MsgRandom' => $dto->getMsgRandom(),
                'MsgTimeStamp' => $dto->getMsgTimeStamp(),
                'MsgBody' => $dto->getMsgBody(),
                'CloudCustomData' => $dto->getCloudCustomData(),
            ],
            [
                'servicename' => 'openim',
                'command' => 'importmsg',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->importMsg($dto));
    }

    public function testGetRoamMsg()
    {
        $client = $this->mockApiClient(Client::class, ['getRoamMsg'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/openim/admin_getroammsg',
            [
                'From_Account' => 'user2',
                'To_Account' => 'user1',
                'MaxCnt' => 100,
                'MinTime' => 1584669600,
                'MaxTime' => 1584673200,
            ],
            [
                'servicename' => 'openim',
                'command' => 'admin_getroammsg',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getRoamMsg(
            'user2',
            'user1',
            100,
            (new \DateTime())->setTimestamp(1584669600),
            (new \DateTime())->setTimestamp(1584673200)
        ));
    }

    public function testMsgWithDraw()
    {
        $client = $this->mockApiClient(Client::class, ['msgWithDraw'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/openim/admin_msgwithdraw',
            [
                'From_Account' => 'user2',
                'To_Account' => 'user1',
                'MsgKey' => 'msg-key'
            ],
            [
                'servicename' => 'openim',
                'command' => 'admin_msgwithdraw',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->msgWithDraw(
            'user2',
            'user1',
            'msg-key'
        ));
    }

    public function testReadMsg()
    {
        $client = $this->mockApiClient(Client::class, ['readMsg'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/openim/admin_set_msg_read',
            [
                'Report_Account' => 'user2',
                'Peer_Account' => 'user1',
            ],
            [
                'servicename' => 'openim',
                'command' => 'admin_set_msg_read',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->readMsg(
            'user2',
            'user1'
        ));
    }

    public function testGetUnreadMsgNum()
    {
        $client = $this->mockApiClient(Client::class, ['getUnreadMsgNum'], $this->app())->makePartial();
        $client->expects()->httpPostJson(
            'v4/openim/get_c2c_unread_msg_num',
            [
                'To_Account' => 'user2',
            ],
            [
                'servicename' => 'openim',
                'command' => 'get_c2c_unread_msg_num',
            ]
        )->andReturn('mock-result');
        $this->assertSame('mock-result', $client->getUnreadMsgNum(
            'user2'
        ));
    }
}
