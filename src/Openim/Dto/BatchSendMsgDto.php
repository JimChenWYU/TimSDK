<?php

namespace TimSDK\Openim\Dto;

use JsonSerializable;
use TimSDK\Kernel\DataStruct\MsgBody;

class BatchSendMsgDto implements JsonSerializable
{
    /**
     * @var int
     */
    protected $syncOtherMachine;
    /**
     * @var string[]
     */
    protected $toAccount;
    /**
     * @var int
     */
    protected $msgLifeTime;
    /**
     * @var int
     */
    protected $msgSeq;
    /**
     * @var int
     */
    protected $msgRandom;
    /**
     * @var int
     */
    protected $msgTimeStamp;
    /**
     * @var MsgBody[]
     */
    protected $msgBody;
    /**
     * @var string
     */
    protected $cloudCustomData;

    /**
     * BatchSendMsgDto constructor.
     * @param int       $syncOtherMachine
     * @param string[]  $toAccount
     * @param int       $msgLifeTime
     * @param int       $msgSeq
     * @param int       $msgRandom
     * @param int       $msgTimeStamp
     * @param MsgBody[] $msgBody
     * @param string    $cloudCustomData
     */
    public function __construct(
        int $syncOtherMachine,
        array $toAccount,
        int $msgLifeTime,
        int $msgSeq,
        int $msgRandom,
        int $msgTimeStamp,
        array $msgBody,
        string $cloudCustomData
    ) {
        $this->syncOtherMachine = $syncOtherMachine;
        $this->toAccount = $toAccount;
        $this->msgLifeTime = $msgLifeTime;
        $this->msgSeq = $msgSeq;
        $this->msgRandom = $msgRandom;
        $this->msgTimeStamp = $msgTimeStamp;
        $this->msgBody = $msgBody;
        $this->cloudCustomData = $cloudCustomData;
    }

    /**
     * @return int
     */
    public function getSyncOtherMachine(): int
    {
        return $this->syncOtherMachine;
    }

    /**
     * @return string[]
     */
    public function getToAccount(): array
    {
        return $this->toAccount;
    }

    /**
     * @return int
     */
    public function getMsgLifeTime(): int
    {
        return $this->msgLifeTime;
    }

    /**
     * @return int
     */
    public function getMsgSeq(): int
    {
        return $this->msgSeq;
    }

    /**
     * @return int
     */
    public function getMsgRandom(): int
    {
        return $this->msgRandom;
    }

    /**
     * @return int
     */
    public function getMsgTimeStamp(): int
    {
        return $this->msgTimeStamp;
    }

    /**
     * @return MsgBody[]
     */
    public function getMsgBody(): array
    {
        return $this->msgBody;
    }

    /**
     * @return string
     */
    public function getCloudCustomData(): string
    {
        return $this->cloudCustomData;
    }

    public function jsonSerialize()
    {
        return [
            'SyncOtherMachine' => $this->syncOtherMachine,
            'To_Account' => $this->toAccount,
            'MsgLifeTime' => $this->msgLifeTime,
            'MsgSeq' => $this->msgSeq,
            'MsgRandom' => $this->msgRandom,
            'MsgTimeStamp' => $this->msgTimeStamp,
            'MsgBody' => $this->msgBody,
            'CloudCustomData' => $this->cloudCustomData,
        ];
    }
}
