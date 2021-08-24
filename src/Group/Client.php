<?php

namespace TimSDK\Group;

use TimSDK\Kernel\BaseClient;
use TimSDK\Kernel\DataStruct\OfflinePushInfo;

class Client extends BaseClient
{
    /**
     * 获取 App 中的所有群组
     * @see https://cloud.tencent.com/document/product/269/1614
     *
     * @param int    $next
     * @param int    $limit
     * @param string $groupType
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function getAppGroup(int $next = 0, int $limit = 10000, string $groupType = '')
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/get_appid_group_list',
            [
                'Next' => $next,
                'Limit' => $limit,
                'GroupType' => $groupType,
            ],
            [
                'servicename' => 'group_open_http_svc',
                'command' => 'get_appid_group_list',
            ]
        );
    }

    /**
     * 创建群组
     * @https://cloud.tencent.com/document/product/269/1615
     *
     * @param string                       $ownerAccount
     * @param string                       $type
     * @param string                       $name
     * @param \TimSDK\Group\GroupInfo|null $info
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function createGroup(string $ownerAccount, string $type, string $name, ?GroupInfo $info = null)
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/create_group',
            array_merge([
                'Owner_Account' => $ownerAccount,
                'Type' => $type,
                'Name' => $name,
            ], $info ? $info->jsonSerialize() : []),
            [
                'servicename' => 'group_open_http_svc',
                'command' => 'create_group',
            ]
        );
    }

    /**
     * 获取群详细资料
     * @see https://cloud.tencent.com/document/product/269/1616
     *
     * @param string[]                              $groupIdList
     * @param \TimSDK\Group\GroupInfoResponseFilter $filter
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function getGroupInfo(array $groupIdList, ?GroupInfoResponseFilter $filter = null)
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/get_group_info',
            array_merge([
                'GroupIdList' => $groupIdList,
            ], $filter ? [
                'ResponseFilter' => $filter->jsonSerialize()
            ] : []),
            [
                'servicename' => 'group_open_http_svc',
                'command' => 'get_group_info',
            ]
        );
    }

    /**
     * 获取群成员详细资料
     * @see https://cloud.tencent.com/document/product/269/1617
     *
     * @param string $groupId
     * @param int    $offset
     * @param int    $limit
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function getGroupMemberInfo(string $groupId, array $memberInfoFilter = [], array $memberRoleFilter = [], array $appDefinedDataFilterGroupMember = [], int $offset = 0, int $limit = 100)
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/get_group_member_info',
            [
                'GroupId' => $groupId,
                'MemberInfoFilter' => $memberInfoFilter,
                'MemberRoleFilter' => $memberRoleFilter,
                'AppDefinedDataFilter_GroupMember' => $appDefinedDataFilterGroupMember,
                'Limit' => $limit,
                'Offset' => $offset,
            ],
            [
                'servicename' => 'group_open_http_svc',
                'command' => 'get_group_member_info',
            ]
        );
    }

    /**
     * @param string                       $groupId
     * @param string                       $name
     * @param bool                         $shutUpAllMember
     * @param array[]                      $appDefinedData
     * @param \TimSDK\Group\GroupInfo|null $info
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function modifyGroupBaseInfo(string $groupId, string $name, bool $shutUpAllMember = false, array $appDefinedData = [], ?GroupInfo $info = null)
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/modify_group_base_info',
            array_merge([
                'GroupId' => $groupId,
                'Name' => $name,
                'ShutUpAllMember' => !$shutUpAllMember ? 'On' : 'Off',
                'AppDefinedData' => $appDefinedData,
            ], $info ? [
                'Introduction' => $info->getIntroduction(),
                'Notification' => $info->getNotification(),
                'FaceUrl' => $info->getFaceUrl(),
                'MaxMemberNum' => $info->getMaxMemberCount(),
                'ApplyJoinOption' => $info->getApplyJoinOption(),
            ] : []),
            [
                'servicename' => 'group_open_http_svc',
                'command' => 'modify_group_base_info',
            ]
        );
    }

    /**
     * 增加群成员
     * @see https://cloud.tencent.com/document/product/269/1621
     *
     * @param string $groupId
     * @param array  $memberList
     * @param bool   $silence
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function addGroupMember(string $groupId, array $memberList, bool $silence = false)
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/add_group_member',
            [
                'GroupId' => $groupId,
                'Silence' => $silence ? 1 : 0,
                'MemberList' => $memberList,
            ],
            [
                'servicename' => 'group_open_http_svc',
                'command' => 'add_group_member',
            ]
        );
    }

    /**
     * 删除群成员
     * @see https://cloud.tencent.com/document/product/269/1622
     *
     * @param string $groupId
     * @param array  $memberToDelAccount
     * @param bool   $silence
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function deleteGroupMember(string $groupId, array $memberToDelAccount, bool $silence = false)
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/delete_group_member',
            [
                'GroupId' => $groupId,
                'Silence' => $silence ? 1 : 0,
                'MemberToDel_Account' => $memberToDelAccount,
            ],
            [
                'servicename' => 'group_open_http_svc',
                'command' => 'delete_group_member',
            ]
        );
    }

    /**
     * 修改群成员资料
     * @see https://cloud.tencent.com/document/product/269/1623
     *
     * @param string $groupId
     * @param string $memberAccount
     * @param string $role
     * @param string $msgFlag
     * @param string $nameCard
     * @param int    $shutUpTime
     * @param array  $appMemberDefinedData
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function modifyGroupMemberInfo(string $groupId, string $memberAccount, string $role = '', string $msgFlag = '', string $nameCard = '', int $shutUpTime = 0, array $appMemberDefinedData = [])
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/modify_group_member_info',
            [
                'GroupId' => $groupId,
                'Member_Account' => $memberAccount,
                'Role' => $role,
                'MsgFlag' => $msgFlag,
                'NameCard' => $nameCard,
                'ShutUpTime' => $shutUpTime,
                'AppMemberDefinedData' => $appMemberDefinedData,
            ],
            [
                'servicename' => 'group_open_http_svc',
                'command' => 'modify_group_member_info',
            ]
        );
    }

    /**
     * 解散群组
     * @see https://cloud.tencent.com/document/product/269/1624
     *
     * @param string $groupId
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function destroyGroup(string $groupId)
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/destroy_group',
            [
                'GroupId' => $groupId,
            ],
            [
                'servicename' => 'group_open_http_svc',
                'command' => 'destroy_group',
            ]
        );
    }

    /**
     * 获取用户所加入的群组
     * @see https://cloud.tencent.com/document/product/269/1625
     *
     * @param string                                       $memberAccount
     * @param string                                       $groupType
     * @param int                                          $withHugeGroups
     * @param int                                          $withNoActiveGroups
     * @param \TimSDK\Group\JoinedGroupResponseFilter|null $filter
     * @param int                                          $offset
     * @param int                                          $limit
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function getJoinedGroupList(string $memberAccount, string $groupType = '', int $withHugeGroups = 0, int $withNoActiveGroups = 0, ?JoinedGroupResponseFilter $filter = null, int $offset = 0, int $limit = 5000)
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/get_joined_group_list',
            [
                'Member_Account' => $memberAccount,
                'Offset' => $offset,
                'Limit' => $limit,
                'GroupType' => $groupType,
                'WithHugeGroups' => $withHugeGroups,
                'WithNoActiveGroups' => $withNoActiveGroups,
                'ResponseFilter' => $filter,
            ],
            [
                'servicename' => 'group_open_http_svc',
                'command' => 'get_joined_group_list',
            ]
        );
    }

    /**
     * @param string $groupId
     * @param string[] $userAccount
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function getRoleInGroup(string $groupId, array $userAccount)
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/get_role_in_group',
            [
                'GroupId' => $groupId,
                'User_Account' => $userAccount,
            ],
            [
                'servicename' => 'group_open_http_svc',
                'command' => 'get_role_in_group',
            ]
        );
    }

    /**
     * 批量禁言和取消禁言
     * @see https://cloud.tencent.com/document/product/269/2925
     *
     * @param string $groupId
     * @param array  $membersAccounts
     * @param int    $shutUpTime
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function forbidSendMsg(string $groupId, array $membersAccounts, int $shutUpTime)
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/forbid_send_msg',
            [
                'GroupId' => $groupId,
                'Members_Account' => $membersAccounts,
                'ShutUpTime' => $shutUpTime
            ],
            [
                'servicename' => 'group_open_http_svc',
                'command' => 'forbid_send_msg',
            ]
        );
    }

    /**
     * 获取被禁言群成员列表
     * @see https://cloud.tencent.com/document/product/269/2925
     *
     * @param string $groupId
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function getGroupShuttedUin(string $groupId)
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/get_group_shutted_uin',
            [
                'GroupId' => $groupId,
            ],
            [
                'servicename' => 'group_open_http_svc',
                'command' => 'get_group_shutted_uin',
            ]
        );
    }

    /**
     * 在群组中发送普通消息
     * @see https://cloud.tencent.com/document/product/269/1629
     *
     * @param string                                         $groupId
     * @param int                                            $random
     * @param \TimSDK\Kernel\DataStruct\MsgBody[]            $msgBody
     * @param string                                         $msgPriority
     * @param string                                         $fromAccount
     * @param \TimSDK\Kernel\DataStruct\OfflinePushInfo|null $offlinePushInfo
     * @param string[]                                       $forbidCallbackControl
     * @param int                                            $onlineOnlyFlag
     * @param string[]                                       $sendMsgControl
     * @param string                                         $cloudCustomData
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function sendGroupMsg(string $groupId, int $random, array $msgBody, string $msgPriority = 'Normal', string $fromAccount = '', ?OfflinePushInfo $offlinePushInfo = null, array $forbidCallbackControl = [], int $onlineOnlyFlag = 0, array $sendMsgControl = [], string $cloudCustomData = '')
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/send_group_msg',
            array_merge([
                'GroupId' => $groupId,
                'Random' => $random,
                'MsgPriority' => $msgPriority,
                'MsgBody' => $msgBody,
                'OnlineOnlyFlag' => $onlineOnlyFlag,
            ], array_filter([
                'From_Account' => $fromAccount,
                'OfflinePushInfo' => $offlinePushInfo,
                'ForbidCallbackControl' => $forbidCallbackControl,
                'SendMsgControl' => $sendMsgControl,
                'CloudCustomData' => $cloudCustomData,
            ])),
            [
                'servicename' => 'group_open_http_svc',
                'command' => 'send_group_msg',
            ]
        );
    }

    /**
     * 在群组中发送系统通知
     * @see https://cloud.tencent.com/document/product/269/1630
     *
     * @param string $groupId
     * @param string $content
     * @param string[] $toMembersAccount
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function sendGroupSystemNotification(string $groupId, string $content, array $toMembersAccount = [])
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/send_group_system_notification',
            [
                'GroupId' => $groupId,
                'Content' => $content,
                'ToMembers_Account' => $toMembersAccount,
            ],
            [
                'servicename' => 'group_open_http_svc',
                'command' => 'send_group_system_notification',
            ]
        );
    }

    /**
     * 转让群主
     * @see https://cloud.tencent.com/document/product/269/1633
     *
     * @param string $groupId
     * @param string $newOwnerAccount
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function changeGroupOwner(string $groupId, string $newOwnerAccount)
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/change_group_owner',
            [
                'GroupId' => $groupId,
                'NewOwner_Account' => $newOwnerAccount,
            ],
            [
                'servicename' => 'group_open_http_svc',
                'command' => 'change_group_owner',
            ]
        );
    }

    /**
     * 撤回群消息
     * @see https://cloud.tencent.com/document/product/269/12341
     *
     * @param string $groupId
     * @param array  $msgSeqList
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function groupMsgRecall(string $groupId, array $msgSeqList)
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/group_msg_recall',
            [
                'GroupId' => $groupId,
                'MsgSeqList' => $msgSeqList,
            ],
            [
                'servicename' => 'group_open_http_svc',
                'command' => 'group_msg_recall',
            ]
        );
    }

    /**
     * 导入群基础资料
     * @see https://cloud.tencent.com/document/product/269/1634
     *
     * @param string                       $type
     * @param string                       $name
     * @param string                       $ownerAccount
     * @param string                       $groupId
     * @param \TimSDK\Group\GroupInfo|null $info
     * @param array                        $appDefinedData
     * @param int                          $createTime
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function importGroup(string $type, string $name, string $ownerAccount = '', string $groupId = '', ?GroupInfo $info = null, array $appDefinedData = [], ?\DateTime $createTime = null)
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/import_group',
            array_merge([
                'Type' => $type,
                'Name' => $name,
                'Owner_Account' => $ownerAccount,
                'GroupId' => $groupId,
                'AppDefinedData' => $appDefinedData,
            ], $info ? $info->jsonSerialize() : [], $createTime ? [
                'CreateTime' => $createTime->getTimestamp(),
            ] : []),
            [
                'servicename' => 'group_open_http_svc',
                'command' => 'import_group',
            ]
        );
    }

    /**
     * 导入群消息
     * @see https://cloud.tencent.com/document/product/269/1635
     *
     * @param string $groupId
     * @param \TimSDK\Group\Message[] $msgList
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function importGroupMsg(string $groupId, array $msgList)
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/import_group_msg',
            [
                'GroupId' => $groupId,
                'MsgList' => $msgList,
            ],
            [
                'servicename' => 'group_open_http_svc',
                'command' => 'import_group_msg',
            ]
        );
    }

    /**
     * 导入群成员
     * @see https://cloud.tencent.com/document/product/269/1636
     *
     * @param string $groupId
     * @param \TimSDK\Group\Member[] $memberList
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function importGroupMember(string $groupId, array $memberList)
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/import_group_member',
            [
                'GroupId' => $groupId,
                'MemberList' => $memberList,
            ],
            [
                'servicename' => 'group_open_http_svc',
                'command' => 'import_group_member',
            ]
        );
    }

    /**
     * 设置成员未读消息计数
     * @see https://cloud.tencent.com/document/product/269/1637
     *
     * @param string $groupId
     * @param string $memberAccount
     * @param int    $unreadMsgNum
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function setUnreadMsgNum(string $groupId, string $memberAccount, int $unreadMsgNum)
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/set_unread_msg_num',
            [
                'GroupId' => $groupId,
                'Member_Account' => $memberAccount,
                'UnreadMsgNum' => $unreadMsgNum,
            ],
            [
                'servicename' => 'group_open_http_svc',
                'command' => 'set_unread_msg_num',
            ]
        );
    }

    /**
     * 撤回指定用户发送的消息
     * @see https://cloud.tencent.com/document/product/269/2359
     *
     * @param string $groupId
     * @param string $senderAccount
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function deleteGroupMsgBySender(string $groupId, string $senderAccount)
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/delete_group_msg_by_sender',
            [
                'GroupId' => $groupId,
                'Sender_Account' => $senderAccount,
            ],
            [
                'servicename' => 'group_open_http_svc',
                'command' => 'delete_group_msg_by_sender',
            ]
        );
    }

    /**
     * 拉取群历史消息
     * @see https://cloud.tencent.com/document/product/269/2738
     *
     * @param string $groupId
     * @param int    $reqMsgNumber
     * @param int    $reqMsgSeq
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function groupMsgGetSimple(string $groupId, int $reqMsgNumber, int $reqMsgSeq = -1)
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/group_msg_get_simple',
            array_merge([
                'GroupId' => $groupId,
                'ReqMsgNumber' => $reqMsgNumber,
            ], $reqMsgSeq === -1 ? [] : [
                'ReqMsgSeq' => $reqMsgSeq
            ]),
            [
                'servicename' => 'group_open_http_svc',
                'command' => 'group_msg_get_simple',
            ]
        );
    }

    /**
     * 获取直播群在线人数
     * @see https://cloud.tencent.com/document/product/269/49180
     *
     * @param string $groupId
     * @return array|object|\Psr\Http\Message\ResponseInterface|string|\TimSDK\Kernel\Support\Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \TimSDK\Kernel\Exceptions\InvalidConfigException
     */
    public function getOnlineMemberNum(string $groupId)
    {
        return $this->httpPostJson(
            'v4/group_open_http_svc/get_online_member_num',
            [
                'GroupId' => $groupId,
            ],
            [
                'servicename' => 'group_open_http_svc',
                'command' => 'get_online_member_num',
            ]
        );
    }
}
