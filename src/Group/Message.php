<?php

namespace TimSDK\Group;

use JsonSerializable;

class Message implements JsonSerializable
{
    /**
     * @var string
     */
    protected $fromAccount;
    /**
     * @var int
     */
    protected $sendTime;
    /**
     * @var int
     */
    protected $random;
    /**
     * @var \TimSDK\Kernel\DataStruct\MsgBody[]
     */
    protected $msgBody;

    /**
     * Message constructor.
     * @param string                              $fromAccount
     * @param int                                 $sendTime
     * @param int                                 $random
     * @param \TimSDK\Kernel\DataStruct\MsgBody[] $msgBody
     */
    public function __construct(string $fromAccount, int $sendTime, int $random, array $msgBody)
    {
        $this->fromAccount = $fromAccount;
        $this->sendTime = $sendTime;
        $this->random = $random;
        $this->msgBody = $msgBody;
    }

    public function jsonSerialize()
    {
        return [
            'From_Account' => $this->fromAccount,
            'SendTime' => $this->sendTime,
            'Random' => $this->random,
            'MsgBody' => $this->msgBody,
        ];
    }
}
