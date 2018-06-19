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
 * @package TimSDK
 * @property \TimSDK\Core\IMCloud $im
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
        return $this['im']->handle($uri, $body, $options);
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
