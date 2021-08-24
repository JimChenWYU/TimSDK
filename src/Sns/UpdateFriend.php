<?php

namespace TimSDK\Sns;

use JsonSerializable;

class UpdateFriend implements JsonSerializable
{
    /**
     * @var string
     */
    protected $toAccount;
    /**
     * @var mixed[]
     */
    protected $snsItem;

    /**
     * UpdateFriend constructor.
     * @param string   $toAccount
     * @param mixed[] $snsItem
     */
    public function __construct(string $toAccount, array $snsItem)
    {
        $this->toAccount = $toAccount;
        $this->snsItem = $snsItem;
    }

    public function jsonSerialize()
    {
        return [
            'To_Account' => $this->toAccount,
            'SnsItem' => $this->snsItem,
        ];
    }
}
