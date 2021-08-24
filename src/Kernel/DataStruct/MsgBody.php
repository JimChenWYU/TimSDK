<?php

namespace TimSDK\Kernel\DataStruct;

use JsonSerializable;
use TimSDK\Kernel\DataStruct\MsgContent\ElemInterface;

class MsgBody implements JsonSerializable
{
    /**
     * @var string
     */
    protected $msgType;
    /**
     * @var ElemInterface
     */
    protected $msgContent;

    /**
     * MsgBody constructor.
     * @param ElemInterface $msgContent
     */
    public function __construct(ElemInterface $msgContent)
    {
        $this->msgType = $msgContent->getMsgType();
        $this->msgContent = $msgContent;
    }

    public function jsonSerialize()
    {
        return [
            'MsgType' => $this->msgType,
            'MsgContent' => $this->msgContent,
        ];
    }
}
