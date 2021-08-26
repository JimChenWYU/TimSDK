<?php

namespace TimSDK\Profile;

use TimSDK\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 设置资料
     * @see https://cloud.tencent.com/document/product/269/1640
     *
     * @param string    $fromAccount
     * @param Profile[] $profileItem
     * @return \TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function setPortrait(string $fromAccount, array $profileItem)
    {
        return $this->httpPostJson(
            'v4/profile/portrait_set',
            [
                'From_Account' => $fromAccount,
                'ProfileItem' => $profileItem
            ],
            [
                'servicename' => 'profile',
                'command' => 'portrait_set',
            ]
        );
    }

    /**
     * 拉取资料
     * @see https://cloud.tencent.com/document/product/269/1639
     *
     * @param string[] $toAccount
     * @param string[] $tagList
     * @return \TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function getPortrait(array $toAccount, array $tagList)
    {
        return $this->httpPostJson(
            'v4/profile/portrait_get',
            [
                'To_Account' => $toAccount,
                'TagList' => $tagList
            ],
            [
                'servicename' => 'profile',
                'command' => 'portrait_get',
            ]
        );
    }
}
