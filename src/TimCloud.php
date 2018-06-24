<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/14/2018
 * Time: 9:01 PM
 */

namespace TimSDK;

use TimSDK\Support\Arr;
use TimSDK\Support\Str;
use TimSDK\Foundation\ResponseBag;
use TimSDK\Container\ServiceContainer;

/**
 * Class TimCloud
 *
 * @package TimSDK
 * @property \TimSDK\Core\IMCloud $im
 * @property \TimSDK\Core\ApiAlias $apiAlias
 * @method \TimSDK\Foundation\ResponseBag requestAccountImport($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestMutiAccountImport($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestRegisterAccountV1($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestKick($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestSendMsg($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestBatchSendMsg($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestImportMsg($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestImPush($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestImGetPushReport($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestImSetAttrName($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestImGetAttrName($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestImSetAttr($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestImRemoveAttr($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestImGetAttr($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestImAddTag($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestImRemoveTag($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestImRemoveAllTags($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestGetAppidGroupList($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestCreateGroup($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestGetGroupInfo($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestGetGroupMemberInfo($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestModifyGroupBaseInfo($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestAddGroupMember($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestDeleteGroupMember($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestModifyGroupMemberInfo($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestDestroyGroup($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestGetJoinedGroupList($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestGetRoleInGroup($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestForbidSendMsg($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestGetGroupShuttedUin($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestSendGroupMsg($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestSendGroupSystemNotification($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestChangeGroupOwner($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestImportGroup($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestImportGroupMsg($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestImportGroupMember($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestSetUnreadMsgNum($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestDeleteGroupMsgBySender($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestGroupMsgGetSimple($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestPortraitGet($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestPortraitSet($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestFriendAdd($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestFriendImport($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestFriendDelete($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestFriendDeleteAll($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestFriendCheck($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestFriendGetAll($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestFriendGetList($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestBlackListAdd($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestBlackListDelete($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestBlackListGet($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestBlackListCheck($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestGroupAdd($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestGroupDelete($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestDirtyWordsGet($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestDirtyWordsAdd($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestDirtyWordsDelete($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestGetHistory($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestQueryState($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestSetNoSpeaking($body = '', $option = [])
 * @method \TimSDK\Foundation\ResponseBag requestGetNoSpeaking($body = '', $option = [])
 */
class TimCloud extends ServiceContainer
{
    /**
     * TimCloud version
     *
     * @var string
     */
    const VERSION = '0.1.2';

    protected $providers = [
        \TimSDK\Core\ServiceProviders\ApiAliasServiceProvider::class,
        \TimSDK\Core\ServiceProviders\IMCloudServiceProvider::class,
    ];

    public function __construct(array $config = [], array $prepends = [])
    {
        if (Arr::has($config, ['private_key', 'public_key'])) {
            $config['private_key'] = $this->formatKey($config['private_key'], 'private');
            $config['public_key'] = $this->formatKey($config['public_key'], 'public');
        }

        parent::__construct($config, $prepends);
    }

    public function setAppId($appid)
    {
        $this->setConfig('app_id', $appid);

        return $this;
    }

    public function setIdentifier($identifier)
    {
        if (!empty($identifier)) {
            $this->setConfig('identifier', $identifier);
        }

        return $this;
    }

    public function setPrivateKey($prikey)
    {
        if (is_file($prikey)) {
            $prikey = file_get_contents($prikey);
        } else {
            $prikey = $this->formatKey($prikey, 'private');
        }

        if (!empty($prikey)) {
            $this->setConfig('private_key', $prikey);
        }

        return $this;
    }

    public function setPublicKey($pubkey)
    {
        if (is_file($pubkey)) {
            $pubkey = file_get_contents($pubkey);
        } else {
            $pubkey = $this->formatKey($pubkey, 'public');
        }

        $this->setConfig('public_key', $pubkey);

        return $this;
    }

    public function formatKey($key, $keyType)
    {
        $keyType = strtoupper($keyType);

        if (Str::startsWith($key, "-----BEGIN $keyType KEY-----")) {
            return $key;
        }

        return "-----BEGIN $keyType KEY-----" . PHP_EOL .
            wordwrap(str_replace(["\r", "\n"], '', $key), 64, PHP_EOL, true) .
            PHP_EOL . "-----END $keyType KEY-----";
    }

    /**
     * Send a request
     *
     * @param string $uri
     * @param string $body
     * @param array  $options
     * @return ResponseBag
     */
    public function request($uri, $body = '', $options = [])
    {
        return $this['im']->handle($this['apiAlias'][$uri], $body, $options);
    }

    /**
     * Get the version number of the application.
     *
     * @return string
     */
    public function version()
    {
        return static::VERSION;
    }

    /**
     * Call request method
     *
     * @param $method
     * @param $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        $method = ltrim($method, 'request');
        $uri = Str::upper(Str::snake($method));
        array_unshift($arguments, $uri);

        return call_user_func_array([$this, 'request'], $arguments);
    }

    protected function setConfig($key, $value)
    {
        if (!empty($value)) {
            $oldVal = $this['config']->get($key, null);
            if ($value !== $oldVal) {
                $this['config']->set($key, $value);
                $this['im']->needRefresh();
            }
        }
    }
}
