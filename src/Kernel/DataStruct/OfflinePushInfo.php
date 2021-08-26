<?php

namespace TimSDK\Kernel\DataStruct;

use JsonSerializable;

class OfflinePushInfo implements JsonSerializable
{
    /**
     * @var string
     */
    protected $pushFlag;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var string
     */
    protected $desc;
    /**
     * @var string
     */
    protected $ext;
    /**
     * @var \TimSDK\Kernel\DataStruct\AndroidInfo
     */
    protected $androidInfo;
    /**
     * @var \TimSDK\Kernel\DataStruct\ApnsInfo
     */
    protected $apnsInfo;

    /**
     * OfflinePushInfo constructor.
     * @param string $pushFlag
     * @param string $title
     * @param string $desc
     * @param string $ext
     * @param \TimSDK\Kernel\DataStruct\AndroidInfo $androidInfo
     * @param \TimSDK\Kernel\DataStruct\ApnsInfo $apnsInfo
     */
    public function __construct(
        string $pushFlag,
        string $title,
        string $desc,
        string $ext,
        AndroidInfo $androidInfo,
        ApnsInfo $apnsInfo
    ) {
        $this->pushFlag = $pushFlag;
        $this->title = $title;
        $this->desc = $desc;
        $this->ext = $ext;
        $this->androidInfo = $androidInfo;
        $this->apnsInfo = $apnsInfo;
    }

    public function jsonSerialize()
    {
        return [
            'PushFlag' => $this->pushFlag,
            'Title' => $this->title,
            'Desc' => $this->desc,
            'Ext' => $this->ext,
            'AndroidInfo' => $this->androidInfo,
            'ApnsInfo' => $this->apnsInfo,
        ];
    }
}
