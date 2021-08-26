<?php

namespace TimSDK\Sns;

use TimSDK\Kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * 添加好友
     * @see https://cloud.tencent.com/document/product/269/1643
     *
     * @param string   $fromAccount
     * @param Friend[] $addFriendItem
     * @return \TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function addFriend(string $fromAccount, array $addFriendItem)
    {
        return $this->httpPostJson(
            'v4/sns/friend_add',
            [
                'From_Account' => $fromAccount,
                'AddFriendItem' => $addFriendItem
            ],
            [
                'servicename' => 'sns',
                'command' => 'friend_add',
            ]
        );
    }

    /**
     * 导入好友
     * @see https://cloud.tencent.com/document/product/269/8301
     *
     * @param string   $fromAccount
     * @param Friend[] $addFriendItem
     * @return \TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function importFriend(string $fromAccount, array $addFriendItem)
    {
        return $this->httpPostJson(
            'v4/sns/friend_import',
            [
                'From_Account' => $fromAccount,
                'AddFriendItem' => $addFriendItem
            ],
            [
                'servicename' => 'sns',
                'command' => 'friend_import',
            ]
        );
    }

    /**
     * @param string         $fromAccount
     * @param UpdateFriend[] $updateItem
     * @return \TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function updateFriend(string $fromAccount, array $updateItem)
    {
        return $this->httpPostJson(
            'v4/sns/friend_update',
            [
                'From_Account' => $fromAccount,
                'UpdateItem' => $updateItem
            ],
            [
                'servicename' => 'sns',
                'command' => 'friend_update',
            ]
        );
    }

    /**
     * 删除好友
     * @see https://cloud.tencent.com/document/product/269/1644
     *
     * @param string   $fromAccount
     * @param string[] $toAccount
     * @param bool     $both
     * @return \TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function deleteFriend(string $fromAccount, array $toAccount, bool $both = true)
    {
        return $this->httpPostJson(
            'v4/sns/friend_delete',
            [
                'From_Account' => $fromAccount,
                'To_Account' => $toAccount,
                'DeleteType' => $both ? 'Delete_Type_Both' : 'Delete_Type_Single'
            ],
            [
                'servicename' => 'sns',
                'command' => 'friend_delete',
            ]
        );
    }

    /**
     * 删除所有好友
     * @see https://cloud.tencent.com/document/product/269/1645
     *
     * @param string $fromAccount
     * @return \TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function deleteAllFriend(string $fromAccount)
    {
        return $this->httpPostJson(
            'v4/sns/friend_delete_all',
            [
                'From_Account' => $fromAccount,
            ],
            [
                'servicename' => 'sns',
                'command' => 'friend_delete_all',
            ]
        );
    }

    /**
     * 校验好友
     * @see https://cloud.tencent.com/document/product/269/1646
     *
     * @param string   $fromAccount
     * @param string[] $toAccount
     * @param bool     $both
     * @return \TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function checkFriend(string $fromAccount, array $toAccount, bool $both = true)
    {
        return $this->httpPostJson(
            'v4/sns/friend_check',
            [
                'From_Account' => $fromAccount,
                'To_Account' => $toAccount,
                'CheckType' => $both ? 'CheckResult_Type_Both' : 'CheckResult_Type_Single',
            ],
            [
                'servicename' => 'sns',
                'command' => 'friend_check',
            ]
        );
    }

    /**
     * 拉取好友
     * @see https://cloud.tencent.com/document/product/269/1647
     *
     * @param string $fromAccount
     * @param int    $startIndex
     * @param int    $standardSequence
     * @param int    $customSequence
     * @return \TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function getFriend(string $fromAccount, int $startIndex, int $standardSequence, int $customSequence)
    {
        return $this->httpPostJson(
            'v4/sns/friend_get',
            [
                'From_Account' => $fromAccount,
                'StartIndex' => $startIndex,
                'StandardSequence' => $standardSequence,
                'CustomSequence' => $customSequence,
            ],
            [
                'servicename' => 'sns',
                'command' => 'friend_get',
            ]
        );
    }

    /**
     * @param string   $fromAccount
     * @param string[] $toAccount
     * @param string[] $tagList
     * @return \TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function getFriendList(string $fromAccount, array $toAccount, array $tagList)
    {
        return $this->httpPostJson(
            'v4/sns/friend_get_list',
            [
                'From_Account' => $fromAccount,
                'To_Account' => $toAccount,
                'TagList' => $tagList,
            ],
            [
                'servicename' => 'sns',
                'command' => 'friend_get_list',
            ]
        );
    }

    /**
     * 添加黑名单
     * @see https://cloud.tencent.com/document/product/269/3718
     *
     * @param string   $fromAccount
     * @param string[] $toAccount
     * @return \TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function addBlacklist(string $fromAccount, array $toAccount)
    {
        return $this->httpPostJson(
            'v4/sns/black_list_add',
            [
                'From_Account' => $fromAccount,
                'To_Account' => $toAccount,
            ],
            [
                'servicename' => 'sns',
                'command' => 'black_list_add',
            ]
        );
    }

    /**
     * 删除黑名单
     * @see https://cloud.tencent.com/document/product/269/3719
     *
     * @param string   $fromAccount
     * @param string[] $toAccount
     * @return \TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function deleteBlacklist(string $fromAccount, array $toAccount)
    {
        return $this->httpPostJson(
            'v4/sns/black_list_delete',
            [
                'From_Account' => $fromAccount,
                'To_Account' => $toAccount,
            ],
            [
                'servicename' => 'sns',
                'command' => 'black_list_delete',
            ]
        );
    }

    /**
     * 拉取黑名单
     * @see https://cloud.tencent.com/document/product/269/3722
     *
     * @param string $fromAccount
     * @param int    $startIndex
     * @param int    $maxLimited
     * @param int    $lastSequence
     * @return \TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function getBlacklist(string $fromAccount, int $startIndex, int $maxLimited, int $lastSequence)
    {
        return $this->httpPostJson(
            'v4/sns/black_list_get',
            [
                'From_Account' => $fromAccount,
                'StartIndex' => $startIndex,
                'MaxLimited' => $maxLimited,
                'LastSequence' => $lastSequence,
            ],
            [
                'servicename' => 'sns',
                'command' => 'black_list_get',
            ]
        );
    }

    /**
     * 校验黑名单
     * @see https://cloud.tencent.com/document/product/269/3725
     *
     * @param string   $fromAccount
     * @param string[] $toAccount
     * @param bool     $both
     * @return \TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function checkBlacklist(string $fromAccount, array $toAccount, bool $both = true)
    {
        return $this->httpPostJson(
            'v4/sns/black_list_check',
            [
                'From_Account' => $fromAccount,
                'To_Account' => $toAccount,
                'CheckType' => $both ? 'BlackCheckResult_Type_Both' : 'BlackCheckResult_Type_Single',
            ],
            [
                'servicename' => 'sns',
                'command' => 'black_list_check',
            ]
        );
    }

    /**
     * 添加分组
     * @see https://cloud.tencent.com/document/product/269/10107
     *
     * @param string   $fromAccount
     * @param string[] $groupNames
     * @param string[] $toAccount
     * @return \TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function addGroup(string $fromAccount, array $groupNames, array $toAccount = [])
    {
        return $this->httpPostJson(
            'v4/sns/group_add',
            [
                'From_Account' => $fromAccount,
                'GroupName' => $groupNames,
                'To_Account' => $toAccount,
            ],
            [
                'servicename' => 'sns',
                'command' => 'group_add',
            ]
        );
    }

    /**
     * 删除分组
     * @see https://cloud.tencent.com/document/product/269/10108
     *
     * @param string $fromAccount
     * @param string[]  $groupNames
     * @return \TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function deleteGroup(string $fromAccount, array $groupNames)
    {
        return $this->httpPostJson(
            'v4/sns/group_delete',
            [
                'From_Account' => $fromAccount,
                'GroupName' => $groupNames
            ],
            [
                'servicename' => 'sns',
                'command' => 'group_delete',
            ]
        );
    }

    /**
     * 拉去分组
     * @see https://cloud.tencent.com/document/product/269/54763
     *
     * @param string $fromAccount
     * @param int    $lastSequence
     * @param string $needFriend
     * @param string[] $groupName
     * @return \TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function getGroup(string $fromAccount, int $lastSequence, string $needFriend = '', array $groupName = [])
    {
        return $this->httpPostJson(
            'v4/sns/group_get',
            [
                'From_Account' => $fromAccount,
                'LastSequence' => $lastSequence,
                'NeedFriend' => $needFriend,
                'GroupName' => $groupName,
            ],
            [
                'servicename' => 'sns',
                'command' => 'group_get',
            ]
        );
    }
}
