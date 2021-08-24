<?php

namespace TimSDK\Kernel\DataStruct\MsgContent;

class TIMSoundElem implements ElemInterface
{
    /**
     * @var string
     */
    protected $url;
    /**
     * @var int
     */
    protected $size;
    /**
     * @var int
     */
    protected $second;
    /**
     * @var int
     */
    protected $downloadFlag;

    /**
     * TIMSoundElem constructor.
     * @param string $url
     * @param int    $size
     * @param int    $second
     * @param int    $downloadFlag
     */
    public function __construct(string $url, int $size, int $second, int $downloadFlag)
    {
        $this->url = $url;
        $this->size = $size;
        $this->second = $second;
        $this->downloadFlag = $downloadFlag;
    }

    public function jsonSerialize()
    {
        return [
            'Url' => $this->url,
            'Size' => $this->size,
            'Second' => $this->second,
            'Download_Flag' => $this->downloadFlag,
        ];
    }

    public function getMsgType(): string
    {
        return 'TIMSoundElem';
    }
}
