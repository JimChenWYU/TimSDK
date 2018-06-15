<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/14/2018
 * Time: 7:23 PM
 */

namespace TimSDK\Core;

interface API
{
    const BASE_URL = 'https://console.tim.qq.com/';

    // 账号管理
    const ACCOUNT_IMPORT = 'v4/im_open_login_svc/account_import';
    const REGISTER_ACCOUNT_V1 = 'v4/registration_service/register_account_v1';
    const KICK = 'v4/im_open_login_svc/kick';

    // 单聊消息
    const SEND_MSG = 'v4/openim/sendmsg';
    const BATCH_SEND_MSG = 'v4/openim/batchsendmsg';
    const IMPORT_MSG = 'v4/openim/importmsg';

    // 消息推送
    const IM_PUSH = 'v4/openim/im_push';
    const IM_GET_PUSH_REPORT = 'v4/openim/im_get_push_report';
    const IM_SET_ATTR_NAME = 'v4/openim/im_set_attr_name';
    const IM_GET_ATTR_NAME = 'v4/openim/im_get_attr_name';
    const IM_SET_ATTR = 'v4/openim/im_set_attr';
    const IM_REMOVE_ATTR = 'v4/openim/im_remove_attr';
    const IM_GET_ATTR = 'v4/openim/im_get_attr';
    const IM_ADD_TAG = 'v4/openim/im_add_tag';
    const IM_REMOVE_TAG = 'v4/openim/im_remove_tag';
    const IM_REMOVE_ALL_TAGS = 'v4/openim/im_remove_all_tags';

    // 群组管理
    const GET_APPID_GROUP_LIST = 'v4/group_open_http_svc/get_appid_group_list';
    const CREATE_GROUP = 'v4/group_open_http_svc/create_group';
    const GET_GROUP_INFO = 'v4/group_open_http_svc/get_group_info';
    const GET_GROUP_MEMBER_INFO = 'v4/group_open_http_svc/get_group_member_info';
    const MODIFY_GROUP_BASE_INFO = 'v4/group_open_http_svc/modify_group_base_info';
    const ADD_GROUP_MEMBER = 'v4/group_open_http_svc/add_group_member';
    const DELETE_GROUP_MEMBER = 'v4/group_open_http_svc/delete_group_member';
    const MODIFY_GROUP_MEMBER_INFO = 'v4/group_open_http_svc/modify_group_member_info';
    const DESTROY_GROUP = 'v4/group_open_http_svc/destroy_group';
    const GET_JOINED_GROUP_LIST = 'v4/group_open_http_svc/get_joined_group_list';
    const GET_ROLE_IN_GROUP = 'v4/group_open_http_svc/get_role_in_group';
    const FORBID_SEND_MSG = 'v4/group_open_http_svc/forbid_send_msg';
    const GET_GROUP_SHUTTED_UIN = 'v4/group_open_http_svc/get_group_shutted_uin';
    const SEND_GROUP_MSG = 'v4/group_open_http_svc/send_group_msg';
    const SEND_GROUP_SYSTEM_NOTIFICATION = 'v4/group_open_http_svc/send_group_system_notification';
    const CHANGE_GROUP_OWNER = 'v4/group_open_http_svc/change_group_owner';
    const IMPORT_GROUP = 'v4/group_open_http_svc/import_group';
    const IMPORT_GROUP_MSG = 'v4/group_open_http_svc/import_group_msg';
    const IMPORT_GROUP_MEMBER = 'v4/group_open_http_svc/import_group_member';
    const SET_UNREAD_MSG_NUM = 'v4/group_open_http_svc/set_unread_msg_num';
    const DELETE_GROUP_MSG_BY_SENDER = 'v4/group_open_http_svc/delete_group_msg_by_sender';
    const GROUP_MSG_GET_SIMPLE = 'v4/group_open_http_svc/group_msg_get_simple';

    // 资料管理
    const PORTRAIT_GET = 'v4/profile/portrait_get';
    const PORTRAIT_SET = 'v4/profile/portrait_set';

    // 关系链管理
    const FRIEND_ADD = 'v4/sns/friend_add';
    const FRIEND_IMPORT = 'v4/sns/friend_import';
    const FRIEND_DELETE = 'v4/sns/friend_delete';
    const FRIEND_DELETE_ALL = 'v4/sns/friend_delete_all';
    const FRIEND_CHECK = 'v4/sns/friend_check';
    const FRIEND_GET_ALL = 'v4/sns/friend_get_all';
    const FRIEND_GET_LIST = 'v4/sns/friend_get_list';
    const BLACK_LIST_ADD = 'v4/sns/black_list_add';
    const BLACK_LIST_DELETE = 'v4/sns/black_list_delete';
    const BLACK_LIST_GET = 'v4/sns/black_list_get';
    const BLACK_LIST_CHECK = 'v4/sns/black_list_check';
    const GROUP_ADD = 'v4/sns/group_add';
    const GROUP_DELETE = 'v4/sns/group_delete';

    // 脏字管理
    const DIRTY_WORDS_GET = 'v4/openim_dirty_words/get';
    const DIRTY_WORDS_ADD = 'v4/openim_dirty_words/add';
    const DIRTY_WORDS_DELETE = 'v4/openim_dirty_words/delete';

    // 数据下载
    const GET_HISTORY = 'v4/open_msg_svc/get_history';

    // 在线状态
    const QUERY_STATE = 'https://console.tim.qq.com/v4/openim/querystate';

    // 全局禁言管理
    const SET_NO_SPEAKING = 'v4/openconfigsvr/setnospeaking';
    const GET_NO_SPEAKING = 'v4/openconfigsvr/getnospeaking';
}
