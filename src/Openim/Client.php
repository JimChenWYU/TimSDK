<?php

namespace TimSDK\Openim;

use DateTime;
use TimSDK\Kernel\BaseClient;
use TimSDK\Openim\Dto\BatchSendMsgDto;
use TimSDK\Openim\Dto\SendMsgDto;

class Client extends BaseClient
{
	/**
	 * 单发单聊消息
	 * @see https://cloud.tencent.com/document/product/269/2282
	 *
	 * @param SendMsgDto $dto
	 * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
	 */
	public function sendMsg(SendMsgDto $dto)
	{
		return $this->httpPostJson(
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
				'command'     => 'sendmsg',
			]
		);
	}

	/**
	 * 批量发单聊消息
	 * @see https://cloud.tencent.com/document/product/269/1612
	 *
	 * @param BatchSendMsgDto $dto
	 * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
	 */
	public function batchSendMsg(BatchSendMsgDto $dto)
	{
		return $this->httpPostJson(
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
				'command'     => 'batchsendmsg',
			]
		);
	}

	/**
	 * 导入单聊消息
	 * @see https://cloud.tencent.com/document/product/269/2568
	 *
	 * @param SendMsgDto $dto
	 * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
	 */
	public function importMsg(SendMsgDto $dto)
	{
		return $this->httpPostJson(
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
				'command'     => 'importmsg',
			]
		);
	}

	/**
	 * 查询单聊消息
	 * @see https://cloud.tencent.com/document/product/269/42794
	 *
	 * @param string $fromAccount
	 * @param string $toAccount
	 * @param int    $maxCnt
	 * @param \DateTime $minTime
	 * @param \DateTime $maxTime
	 */
	public function getRoamMsg(string $fromAccount, string $toAccount, int $maxCnt, DateTime $minTime, DateTime $maxTime)
	{
		return $this->httpPostJson(
			'v4/openim/admin_getroammsg',
			[
				'From_Account' => $fromAccount,
				'To_Account'   => $toAccount,
				'MaxCnt'       => $maxCnt,
				'MinTime'      => $minTime->getTimestamp(),
				'MaxTime'      => $maxTime->getTimestamp(),
			],
			[
				'servicename' => 'openim',
				'command'     => 'admin_getroammsg',
			]
		);
	}

	/**
	 * 撤回单聊消息
	 * @see https://cloud.tencent.com/document/product/269/38980
	 *
	 * @param string $fromAccount
	 * @param string $toAccount
	 * @param string $msgKey
	 * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
	 */
	public function msgWithDraw(string $fromAccount, string $toAccount, string $msgKey)
	{
		return $this->httpPostJson(
			'v4/openim/admin_msgwithdraw',
			[
				'From_Account' => $fromAccount,
				'To_Account'   => $toAccount,
				'MsgKey'       => $msgKey,
			],
			[
				'servicename' => 'openim',
				'command'     => 'admin_msgwithdraw',
			]
		);
	}

	/**
	 * 设置单聊消息已读
	 * @see https://cloud.tencent.com/document/product/269/50349
	 *
	 * @param string $reportAccount
	 * @param string $peerAccount
	 * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
	 */
	public function readMsg(string $reportAccount, string $peerAccount)
	{
		return $this->httpPostJson(
			'v4/openim/admin_set_msg_read',
			[
				'Report_Account' => $reportAccount,
				'Peer_Account' => $peerAccount,
			],
			[
				'servicename' => 'openim',
				'command'     => 'admin_set_msg_read',
			]
		);
	}

	/**
	 * 查询单聊未读消息计数
	 * @see https://cloud.tencent.com/document/product/269/56043
	 *
	 * @param string $account
	 * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
	 */
	public function getUnreadMsgNum(string $account)
	{
		return $this->httpPostJson(
			'v4/openim/get_c2c_unread_msg_num',
			[
				'To_Account' => $account
			],
			[
				'servicename' => 'openim',
				'command'     => 'get_c2c_unread_msg_num',
			]
		);
	}
}