<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2018/6/15
 * Time: 23:30
 */

namespace TimSDK\Foundation;

use TimSDK\Core\Exceptions\JsonParseException;
use TimSDK\Support\Collection;
use TimSDK\Support\Json;

/**
 * Class ResponseBag
 * @package TimSDK\Foundation
 */
class ResponseBag
{
    /**
     * @var Collection
     */
    protected $headers;

    /**
     * @var Collection
     */
    protected $contents;

    /**
     * Http status code
     *
     * @var int
     */
    protected $statusCode;

    public function __construct($contents, $headers, $statusCode = 200)
    {
        $this->contents = $this->getCollectionItems($contents);
        $this->headers = $this->getCollectionItems($headers);
        $this->statusCode = $statusCode;
    }

    /**
     * @return Collection
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return Collection
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * Get a header parameter
     *
     * @param      $name
     * @param null $default
     * @return mixed
     */
    public function getHeader($name, $default = null)
    {
        return $this->headers->get($name, $default);
    }

    /**
     * Get a contents parameter
     *
     * @param      $name
     * @param null $default
     * @return mixed
     */
    public function getContent($name, $default = null)
    {
        return $this->contents->get($name, $default);
    }

    /**
     * Results array of items from Collection or Arrayable.
     *
     * @param $items
     * @return Collection
     */
    protected function getCollectionItems($items)
    {
        if ($items instanceof Collection) {
            return $items;
        } elseif ($items instanceof \JsonSerializable) {
            $items = $items->jsonSerialize();
        } elseif (is_string($items)) {
            try {
                $items = Json::decode($items, true);
            } catch (JsonParseException $e) {
            }
        }

        return new Collection((array) $items);
    }
}
