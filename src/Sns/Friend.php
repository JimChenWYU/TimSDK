<?php

namespace TimSDK\Sns;

use JsonSerializable;

class Friend implements JsonSerializable
{
    /**
     * @var string
     */
    protected $toAccount;
    /**
     * @var string
     */
    protected $addSource;

    /**
     * Friend constructor.
     * @param string $toAccount
     * @param string $addSource
     */
    public function __construct(string $toAccount, string $addSource)
    {
        $this->toAccount = $toAccount;
        $this->addSource = $addSource;
    }

    public function jsonSerialize()
    {
        return [
            'To_Account' => $this->toAccount,
            'AddSource' => $this->addSource,
        ];
    }
}
