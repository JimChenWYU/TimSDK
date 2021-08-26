<?php

namespace TimSDK\MemberPush;

use JsonSerializable;

class UserTag implements JsonSerializable
{
    /**
     * @var string
     */
    protected $toAccount;
    /**
     * @var string[]
     */
    protected $tags;

    /**
     * UserTag constructor.
     * @param string   $toAccount
     * @param string[] $tags
     */
    public function __construct(string $toAccount, array $tags)
    {
        $this->toAccount = $toAccount;
        $this->tags = $tags;
    }

    public function jsonSerialize()
    {
        return [
            'To_Account' => $this->toAccount,
            'Tags' => $this->tags,
        ];
    }
}
