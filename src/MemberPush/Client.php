<?php

namespace TimSDK\MemberPush;

use TimSDK\Kernel\BaseClient;
use TimSDK\Kernel\DataStruct\MsgBody;

class Client extends BaseClient
{
    /**
     * 全员推送
     * @see https://cloud.tencent.com/document/product/269/45934
     *
     * @param string    $fromAccount
     * @param int       $msgRandom
     * @param MsgBody[] $msgBody
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function pushAllMember(string $fromAccount, int $msgRandom, array $msgBody)
    {
        return $this->httpPostJson(
            'v4/all_member_push/im_push',
            [
                'From_Account' => $fromAccount,
                'MsgRandom' => $msgRandom,
                'MsgBody' => $msgBody,
            ],
            [
                'servicename' => 'all_member_push',
                'command' => 'im_push',
            ]
        );
    }

    /**
     * 设置应用属性名称
     *
     * 本功能仅针对旗舰版客户开放申请（如您降级为专业版将无法使用）。
     * @see https://cloud.tencent.com/document/product/269/45935
     *
     * @param array<string, string> $attrNames
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function setAppAttr(array $attrNames)
    {
        return $this->httpPostJson(
            'v4/all_member_push/im_set_attr_name',
            [
                'AttrNames' => $attrNames,
            ],
            [
                'servicename' => 'all_member_push',
                'command' => 'im_set_attr_name',
            ]
        );
    }

    /**
     * 获取应用属性名称
     *
     * 本功能仅针对旗舰版客户开放申请（如您降级为专业版将无法使用）。
     * @see https://cloud.tencent.com/document/product/269/45936
     *
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function getAppAttr()
    {
        return $this->httpPostJson(
            'v4/all_member_push/im_get_attr_name',
            [],
            [
                'servicename' => 'all_member_push',
                'command' => 'im_get_attr_name',
            ]
        );
    }

    /**
     * 获取用户属性
     *
     * 本功能仅针对旗舰版客户开放申请（如您降级为专业版将无法使用）。
     * @see https://cloud.tencent.com/document/product/269/45937
     *
     * @param string[] $toAccount
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function getUserAttr(array $toAccount)
    {
        return $this->httpPostJson(
            'v4/all_member_push/im_get_attr',
            [
                'To_Account' => $toAccount
            ],
            [
                'servicename' => 'all_member_push',
                'command' => 'im_get_attr',
            ]
        );
    }

    /**
     * 设置用户属性
     * @see https://cloud.tencent.com/document/product/269/45938
     *
     * @param UserAttr[] $userAttrs
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function setUserAttr(array $userAttrs)
    {
        return $this->httpPostJson(
            'v4/all_member_push/im_set_attr',
            [
                'UserAttrs' => $userAttrs
            ],
            [
                'servicename' => 'all_member_push',
                'command' => 'im_set_attr',
            ]
        );
    }

    /**
     * 删除用户属性
     * @see https://cloud.tencent.com/document/product/269/45939
     *
     * @param UserAttr[] $userAttrs
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function removeUserAttr(array $userAttrs)
    {
        return $this->httpPostJson(
            'v4/all_member_push/im_remove_attr',
            [
                'UserAttrs' => $userAttrs
            ],
            [
                'servicename' => 'all_member_push',
                'command' => 'im_remove_attr',
            ]
        );
    }

    /**
     * 获取用户标签
     * @see https://cloud.tencent.com/document/product/269/45940
     *
     * @param string[] $toAccount
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function getTag(array $toAccount)
    {
        return $this->httpPostJson(
            'v4/all_member_push/im_get_tag',
            [
                'To_Account' => $toAccount,
            ],
            [
                'servicename' => 'all_member_push',
                'command' => 'im_get_tag',
            ]
        );
    }

    /**
     * 添加用户标签
     * @see https://cloud.tencent.com/document/product/269/45941
     *
     * @param UserTag[] $userTags
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function addTag(array $userTags)
    {
        return $this->httpPostJson(
            'v4/all_member_push/im_add_tag',
            [
                'UserTags' => $userTags,
            ],
            [
                'servicename' => 'all_member_push',
                'command' => 'im_add_tag',
            ]
        );
    }

    /**
     * 删除用户标签
     * @see https://cloud.tencent.com/document/product/269/45942
     *
     * @param UserTag[] $userTags
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function removeTag(array $userTags)
    {
        return $this->httpPostJson(
            'v4/all_member_push/im_remove_tag',
            [
                'UserTags' => $userTags,
            ],
            [
                'servicename' => 'all_member_push',
                'command' => 'im_remove_tag',
            ]
        );
    }

    /**
     * 删除用户所有标签
     * @see https://cloud.tencent.com/document/product/269/45943
     *
     * @param string[] $toAccount
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function removeAllTags(array $toAccount)
    {
        return $this->httpPostJson(
            'v4/all_member_push/im_remove_all_tags',
            [
                'To_Account' => $toAccount,
            ],
            [
                'servicename' => 'all_member_push',
                'command' => 'im_remove_all_tags',
            ]
        );
    }
}
