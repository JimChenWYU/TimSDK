<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/14/2018
 * Time: 8:08 PM
 */

namespace TimSDK\Service;

use TimSDK\Core\AbstractTimSDKAPI;
use TimSDK\Core\Exceptions\MissingArgumentsException;
use TimSDK\Foundation\Application;
use TimSDK\Support\Arr;
use TimSDK\Support\Collection;
use TimSDK\Support\Json;
use TimSDK\Support\Log;
use TimSDK\Support\Str;

class IMCloud extends AbstractTimSDKAPI
{
    /**
     * @var Collection
     */
    protected $query;

    /**
     * @var bool
     */
    protected $needRefresh = false;

    /**
     * Set on refresh swith
     */
    public function needRefresh()
    {
        $this->needRefresh = true;
    }

    /**
     * @return bool
     */
    public function isNeedRefresh()
    {
        return (bool) $this->needRefresh;
    }

    /**
     * Init
     *
     * @throws MissingArgumentsException
     * @throws \TimSDK\Core\Exceptions\UserSigException
     */
    public function initialize()
    {
        $this->query = new Collection($this->getQueryStringArrayData());
    }

    /**
     * Query Getter
     *
     * @param bool $force
     * @return Collection
     * @throws MissingArgumentsException
     * @throws \TimSDK\Core\Exceptions\UserSigException
     */
    public function getQuery($force = false)
    {
        if ($this->needRefresh || $force) {
            $this->query = $this->getQueryStringArrayData();
            $this->needRefresh = false;
        }

        return $this->query;
    }

    /**
     * Api Call Method
     *
     * @param       $uri
     * @param       $body
     * @param array $options
     * @return \TimSDK\Support\Collection
     * @throws MissingArgumentsException
     * @throws \TimSDK\Core\Exceptions\HttpException
     * @throws \TimSDK\Core\Exceptions\JsonParseException
     * @throws \TimSDK\Core\Exceptions\UserSigException
     */
    public function apiCall($uri, $body, $options = [])
    {
        return $this->parseJSON(self::POST, [
            $this->getFullApiUrl($uri),
            array_merge([
                'body'  => $this->getRequestBody($body),
                'query' => $this->getQuery(),
            ], $options),
        ]);
    }

    /**
     * Get the rrl query string array
     *
     * @return array
     * @throws MissingArgumentsException
     * @throws \TimSDK\Core\Exceptions\UserSigException
     */
    protected function getQueryStringArrayData()
    {
        $data = Arr::only($this->app['config']->all(), [
            'sdkappid',
            'identifier',
            'prikey',
            'pubkey',
            'random',
            'contenttype',
        ]);

        if (!isset($data['random'])) {
            $data['random'] = time();
        }

        if (!isset($data['contenttype'])) {
            $data['contenttype'] = self::JSON;
        }

        foreach (['sdkappid', 'identifier', 'prikey', 'pubkey'] as $item) {
            if (!isset($data[$item])) {
                Log::debug('IMCloud Query: ', $data);
                throw new MissingArgumentsException('Missing ' . $item);
            }
        }

        $data['usersig'] = $this->generateSig($data['identifier']);

        return $data;
    }

    /**
     * Generate sig
     *
     * @param $identifier
     * @return string
     * @throws \TimSDK\Core\Exceptions\UserSigException
     */
    public function generateSig($identifier)
    {
        return $this->getTLSSigApi()->genSig($identifier);
    }

    /**
     * TLSSigApi
     *
     * @return TLSSigApi
     */
    protected function getTLSSigApi()
    {
        return $this->app['TLSSig'];
    }

    /**
     * Reset request body
     *
     * @param $body
     * @return string
     * @throws \TimSDK\Core\Exceptions\JsonParseException
     */
    protected function getRequestBody($body = '')
    {
        if (empty($body)) {
            $body = '{}';
        }

        return is_string($body) ? $body : Json::encode($body);
    }

    /**
     * Get a full url
     *
     * @param $uri
     * @return string
     */
    protected function getFullApiUrl($uri)
    {
        return Str::startsWith($uri, ['http', 'https']) ? $uri : API::BASE_URL . $uri;
    }
}
