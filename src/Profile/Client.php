<?php

namespace TimSDK\Profile;

use TimSDK\Kernel\BaseClient;

class Client extends BaseClient
{
	/**
	 * 设置资料
	 * @see https://cloud.tencent.com/document/product/269/1640
	 *
	 * @param string $account
	 * @param Profile[]  $profileItems
	 * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
	 */
	public function setPortrait(string $account, array $profileItems)
	{
		return $this->httpPostJson(
			'v4/profile/portrait_set',
			[
				'From_Account' => $account,
				'ProfileItem' => $profileItems
			],
			[
				'servicename' => 'profile',
				'command'     => 'portrait_set',
			]
		);
	}

	/**
	 * 拉取资料
	 * @see https://cloud.tencent.com/document/product/269/1639
	 *
	 * @param string[] $accounts
	 * @param string[] $tags
	 * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
	 */
	public function getPortrait(array $accounts, array $tags)
	{
		return $this->httpPostJson(
			'v4/profile/portrait_get',
			[
				'To_Account' => $accounts,
				'TagList'    => $tags
			],
			[
				'servicename' => 'profile',
				'command'     => 'portrait_get',
			]
		);
	}
}