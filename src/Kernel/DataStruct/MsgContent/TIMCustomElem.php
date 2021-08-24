<?php

namespace TimSDK\Kernel\DataStruct\MsgContent;

class TIMCustomElem implements ElemInterface
{
    /**
     * @var string
     */
    protected $data;
    /**
     * @var string
     */
    protected $desc;
    /**
     * @var string
     */
    protected $ext;
    /**
     * @var string
     */
    protected $sound;

    /**
     * TIMCustomElem constructor.
     * @param string $data
     * @param string $desc
     * @param string $ext
     * @param string $sound
     */
    public function __construct(string $data, string $desc, string $ext, string $sound)
    {
        $this->data = $data;
        $this->desc = $desc;
        $this->ext = $ext;
        $this->sound = $sound;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'Data' => $this->data,
            'Desc' => $this->desc,
            'Ext' => $this->ext,
            'Sound' => $this->sound,
        ];
    }

    public function getMsgType(): string
    {
        return 'TIMCustomElem';
    }
}
