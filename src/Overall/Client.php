<?php

namespace TimSDK\Overall;

use TimSDK\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 设置全局禁言
     * @see https://cloud.tencent.com/document/product/269/4230
     *
     * @param string $setAccount
     * @param int    $c2CmsgNospeakingTime
     * @param int    $groupmsgNospeakingTime
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function setNoSpeaking(string $setAccount, int $c2CmsgNospeakingTime = -1, int $groupmsgNospeakingTime = -1)
    {
        return $this->httpPostJson(
            'v4/openconfigsvr/setnospeaking',
            array_merge([
                'Set_Account' => $setAccount,
            ], $c2CmsgNospeakingTime === -1 ? [] : [
                'C2CmsgNospeakingTime' => $c2CmsgNospeakingTime,
            ], $groupmsgNospeakingTime === -1 ? [] : [
                'GroupmsgNospeakingTime' => $groupmsgNospeakingTime,
            ]),
            [
                'servicename' => 'openconfigsvr',
                'command' => 'setnospeaking',
            ]
        );
    }

    /**
     * 查询全局禁言
     * @see https://cloud.tencent.com/document/product/269/4229
     *
     * @param string $getAccount
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function getNoSpeaking(string $getAccount)
    {
        return $this->httpPostJson(
            'v4/openconfigsvr/getnospeaking',
            [
                'Get_Account' => $getAccount,
            ],
            [
                'servicename' => 'openconfigsvr',
                'command' => 'getnospeaking',
            ]
        );
    }
}
