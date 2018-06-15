<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/14/2018
 * Time: 9:01 PM
 */

namespace TimSDK;

use TimSDK\Foundation\Application;
use TimSDK\Service\IMCloud;
use TimSDK\Support\Arr;
use TimSDK\Support\Str;

/**
 * Class TimCloud
 * @package TimSDK
 * @property IMCloud $im
 */
class TimCloud extends Application
{
    protected $providers = [
        \TimSDK\Core\ServiceProviders\IMCloudServiceProvider::class
    ];

    public function __construct(array $config = [], array $prepends = [])
    {
        if (Arr::has($config, ['prikey', 'pubkey'])) {
            if (!Str::startsWith($config['prikey'], '-----BEGIN')) {
                $config['prikey'] = $this->formatKey($config['prikey'], 'private');
            }

            if (!Str::startsWith($config['pubkey'], '-----BEGIN')) {
                $config['pubkey'] = $this->formatKey($config['pubkey'], 'public');
            }
        }

        parent::__construct($config, $prepends);
    }

    public function setSdkAppid($appid)
    {
        $this->setConfig('sdkappid', $appid);

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
            $this->setConfig('prikey', $prikey);
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

        $this->setConfig('pubkey', $pubkey);

        return $this;
    }

    public function formatKey($key, $keyType)
    {
        $keyType = strtoupper($keyType);
        return "-----BEGIN $keyType KEY-----" . PHP_EOL .
            wordwrap(str_replace(["\r", "\n"], '', $key), 64, PHP_EOL, true) .
            PHP_EOL . "-----END $keyType KEY-----";
    }

    protected function setConfig($key, $value)
    {
        if (! empty($value)) {
            $oldVal = $this['config']->get($key, null);
            if ($value !== $oldVal) {
                $this['config']->set($key, $value);
                $this['im']->needRefresh();
            }
        }
    }
}
