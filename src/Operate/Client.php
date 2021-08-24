<?php

namespace TimSDK\Operate;

use TimSDK\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 拉取运营数据
     * @see https://cloud.tencent.com/document/product/269/4193
     *
     * @param string[] $requestField
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function getAppInfo(array $requestField = [])
    {
        return $this->httpPostJson(
            'v4/openconfigsvr/getappinfo',
            [
                'RequestField' => $requestField,
            ],
            [
                'servicename' => 'openconfigsvr',
                'command' => 'getappinfo',
            ]
        );
    }

    /**
     * 下载最近消息记录
     * @see https://cloud.tencent.com/document/product/269/1650
     *
     * @param string $chatType
     * @param string $msgTime
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function getHistory(string $chatType, string $msgTime)
    {
        return $this->httpPostJson(
            'v4/open_msg_svc/get_history',
            [
                'ChatType' => $chatType,
                'MsgTime' => $msgTime
            ],
            [
                'servicename' => 'open_msg_svc',
                'command' => 'get_history',
            ]
        );
    }

    /**
     * 获取服务器 IP 地址
     * @see https://cloud.tencent.com/document/product/269/45438
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function getIpList()
    {
        return $this->httpPostJson(
            'v4/ConfigSvc/GetIPList',
            [
            ],
            [
                'servicename' => 'ConfigSvc',
                'command' => 'GetIPList',
            ]
        );
    }
}
