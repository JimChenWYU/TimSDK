<?php

namespace TimSDK\Account;

use TimSDK\Kernel\BaseClient;

class Client extends BaseClient
{
	/**
	 * 导入单个帐号
	 *
	 * 本接口用于将 App 自有帐号导入即时通信 IM 帐号系统，为该帐号创建一个对应的内部 ID，使该帐号能够使用即时通信 IM 服务。
	 * @see https://cloud.tencent.com/document/product/269/1608
	 *
	 * @param string $identifier
	 * @param string $nick
	 * @param string $faceUrl
	 * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
	 */
	public function import(string $identifier, string $nick, string $faceUrl)
	{
		return $this->httpPostJson(
			'v4/im_open_login_svc/account_import',
			[
				'Identifier' => $identifier,
				'Nick' => $nick,
				'FaceUrl' => $faceUrl,
			],
			[
				'servicename' => 'im_open_login_svc',
				'command'     => 'account_import',
			]
		);
	}

	/**
	 * 导入多个帐号
	 *
	 * 本接口用于批量将 App 自有帐号导入即时通信 IM 帐号系统，为该帐号创建一个对应的内部 ID，使该帐号能够使用即时通信 IM 服务。
	 * @see https://cloud.tencent.com/document/product/269/4919
	 *
	 * @param string[] $accounts
	 * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
	 */
	public function multiImport(array $accounts)
	{
		return $this->httpPostJson(
			'v4/im_open_login_svc/multiaccount_import',
			[
				'Accounts' => $accounts
			],
			[
				'servicename' => 'im_open_login_svc',
				'command'     => 'multiaccount_import',
			]
		);
	}

	/**
	 * 删除帐号
	 * @see https://cloud.tencent.com/document/product/269/36443
	 *
	 * @param object[] $deleteItem
	 * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
	 */
	public function delete(array $deleteItem)
	{
		return $this->httpPostJson(
			'v4/im_open_login_svc/account_delete',
			[
				'DeleteItem' => $deleteItem
			],
			[
				'servicename' => 'im_open_login_svc',
				'command'     => 'account_delete',
			]
		);
	}

	/**
	 * 查询帐号
	 * @see https://cloud.tencent.com/document/product/269/38417
	 *
	 * @param object[] $checkItem
	 * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
	 */
	public function checkAccount(array $checkItem)
	{
		return $this->httpPostJson(
			'v4/im_open_login_svc/account_check',
			[
				'CheckItem' => $checkItem
			],
			[
				'servicename' => 'im_open_login_svc',
				'command'     => 'account_check',
			]
		);
	}

	/**
	 * 失效帐号登录状态
	 * @see https://cloud.tencent.com/document/product/269/3853
	 *
	 * @param string $identifier
	 * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
	 */
	public function kick(string $identifier)
	{
		return $this->httpPostJson(
			'v4/im_open_login_svc/kick',
			[
				'Identifier' => $identifier,
			],
			[
				'servicename' => 'im_open_login_svc',
				'command'     => 'kick',
			]
		);
	}

	/**
	 * 查询帐号在线状态
	 * @see https://cloud.tencent.com/document/product/269/2566
	 *
	 * @param string[] $toAccount
	 * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
	 */
	public function queryState(array $toAccount)
	{
		return $this->httpPostJson(
			'v4/openim/querystate',
			[
				'To_Account' => $toAccount,
			],
			[
				'servicename' => 'openim',
				'command'     => 'querystate',
			]
		);
	}
}