<?php

namespace TimSDK\Kernel\DataStruct;

use JsonSerializable;

class AndroidInfo implements JsonSerializable
{
    /**
     * @var string
     */
    protected $sound;
    /**
     * @var string
     */
    protected $oppoChannelID;
    /**
     * @var string
     */
    protected $vivoClassification;

    /**
     * AndroidInfo constructor.
     * @param string $sound
     * @param string $oppoChannelID
     * @param string $vivoClassification
     */
    public function __construct(string $sound, string $oppoChannelID, string $vivoClassification)
    {
        $this->sound = $sound;
        $this->oppoChannelID = $oppoChannelID;
        $this->vivoClassification = $vivoClassification;
    }

    public function jsonSerialize()
    {
        return [
            'Sound' => $this->sound,
            'OPPOChannelID' => $this->oppoChannelID,
            'VIVOClassification' => $this->vivoClassification,
        ];
    }
}
