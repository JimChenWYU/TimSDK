<?php

namespace TimSDK\Group;

use JsonSerializable;

class KVItem implements JsonSerializable
{
    /**
     * @var string
     */
    protected $key;
    /**
     * @var string
     */
    protected $value;

    /**
     * KVItem constructor.
     * @param string $key
     * @param string $value
     */
    public function __construct(string $key, string $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function jsonSerialize()
    {
        return [
            'Key' => $this->key,
            'Value' => $this->value,
        ];
    }
}
