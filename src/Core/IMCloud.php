<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/14/2018
 * Time: 8:08 PM
 */

namespace TimSDK\Core;

use TimSDK\Support\Str;
use TimSDK\Support\Log;
use TimSDK\Support\Arr;
use TimSDK\Support\Collection;
use TimSDK\Core\Exceptions\HttpException;
use TimSDK\Core\Exceptions\MissingArgumentsException;

class IMCloud extends BaseIMCloud
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
        $this->initializeQuery();
    }

    /**
     * Request api
     *
     * @param       $uri
     * @param array $data
     * @param array $options
     * @return \TimSDK\Foundation\ResponseBag
     * @throws \TimSDK\Core\Exceptions\JsonParseException
     * @throws \TimSDK\Core\Exceptions\UserSigException
     * @throws \TimSDK\Core\Exceptions\HttpException
     * @throws \TimSDK\Core\Exceptions\MissingArgumentsException
     */
    public function handle($uri, $data = [], $options = [])
    {
        if (empty($data)) {
            $data = '{}';
        }

        $response = $this->httpPostJson($uri, $data, array_merge($options, [
            'query' => $this->getLatestQueryString([
                'sdkappid', 'usersig', 'identifier', 'random', 'contenttype'
            ])
        ]));

        $this->checkAndThrow($response->getContents());

        return $response;
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
        return $this->app['TLSSig']->genSig($identifier);
    }

    /**
     * Get the latest config parameters array
     *
     * @return array
     * @throws Exceptions\UserSigException
     * @throws MissingArgumentsException
     */
    public function getLatestConfigParameters()
    {
        $data = Arr::only($this->app['config']->all(), [
            'app_id',
            'identifier',
            'private_key',
            'public_key',
            'random',
            'contenttype',
        ]);

        if (!isset($data['random'])) {
            $data['random'] = time();
        }

        if (!isset($data['contenttype'])) {
            $data['contenttype'] = 'json';
        }

        foreach (['app_id', 'identifier', 'public_key', 'private_key'] as $item) {
            if (empty(Arr::get($data, $item, null))) {
                Log::debug('IMCloud Query: ', $data);
                throw new MissingArgumentsException("Missing $item.");
            }
        }

        $data['usersig'] = $this->generateSig($data['identifier']);
        $data['sdkappid'] = $data['app_id'];

        return $data;
    }

    /**
     * Get query string array
     *
     * @param array $fields
     * @return array
     * @throws Exceptions\UserSigException
     * @throws MissingArgumentsException
     */
    public function getLatestQueryString(array $fields = ['*'])
    {
        $this->initializeQuery();

        if ($this->needRefresh) {
            $this->needRefresh = false;
            $this->query->setAll($this->getLatestConfigParameters());
        }

        if (count($fields) == 1 && $fields[0] === '*') {
            return $this->query->toArray();
        }

        return $this->query->only($fields);
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

    /**
     * Check the array data errors, and Throw exception when the contents contains error.
     *
     * @param array|Collection $contents
     *
     * @throws HttpException
     */
    protected function checkAndThrow($contents)
    {
        if ($contents instanceof Collection) {
            $contents = $contents->toArray();
        }

        if (isset($contents['ErrorCode']) && 0 !== $contents['ErrorCode']) {
            if (empty($contents['ErrorInfo'])) {
                $contents['ErrorInfo'] = 'Unknown';
            }
            throw new HttpException($contents['ErrorInfo'], $contents['ErrorCode']);
        }
    }

    /**
     * Initialize query
     *
     * @param array $items
     * @return Collection
     * @throws Exceptions\UserSigException
     * @throws MissingArgumentsException
     */
    protected function initializeQuery(array $items = [])
    {
        if (!$this->query instanceof Collection) {
            $this->query = new Collection($items ?: $this->getLatestConfigParameters());
        }

        return $this->query;
    }
}
