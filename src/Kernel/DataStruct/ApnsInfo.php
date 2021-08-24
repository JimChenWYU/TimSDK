<?php

namespace TimSDK\Kernel\DataStruct;

use JsonSerializable;

class ApnsInfo implements JsonSerializable
{
    /**
     * @var string
     */
    protected $sound;
    /**
     * @var int
     */
    protected $badgeMode;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var string
     */
    protected $subTitle;
    /**
     * @var string
     */
    protected $image;
    /**
     * @var int
     */
    protected $mutableContent;

    /**
     * ApnsInfo constructor.
     * @param string $sound
     * @param int    $badgeMode
     * @param string $title
     * @param string $subTitle
     * @param string $image
     * @param int    $mutableContent
     */
    public function __construct(
        string $sound,
        int $badgeMode,
        string $title,
        string $subTitle,
        string $image,
        int $mutableContent
    ) {
        $this->sound = $sound;
        $this->badgeMode = $badgeMode;
        $this->title = $title;
        $this->subTitle = $subTitle;
        $this->image = $image;
        $this->mutableContent = $mutableContent;
    }

    public function jsonSerialize()
    {
        return [
            'Sound' => $this->sound,
            'BadgeMode' => $this->badgeMode,
            'Title' => $this->title,
            'SubTitle' => $this->subTitle,
            'Image' => $this->image,
            'MutableContent' => $this->mutableContent,
        ];
    }
}
