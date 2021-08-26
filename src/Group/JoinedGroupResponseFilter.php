<?php

namespace TimSDK\Group;

use JsonSerializable;

class JoinedGroupResponseFilter implements JsonSerializable
{
    /**
     * @var string[]
     */
    protected $groupBaseInfoFilter;
    /**
     * @var string[]
     */
    protected $selfInfoFilter;

    /**
     * JoinedGroupResponseFilter constructor.
     * @param string[] $groupBaseInfoFilter
     * @param string[] $selfInfoFilter
     */
    public function __construct(array $groupBaseInfoFilter, array $selfInfoFilter)
    {
        $this->groupBaseInfoFilter = $groupBaseInfoFilter;
        $this->selfInfoFilter = $selfInfoFilter;
    }

    public function jsonSerialize()
    {
        return [
            'GroupBaseInfoFilter' => $this->groupBaseInfoFilter,
            'SelfInfoFilter' => $this->selfInfoFilter,
        ];
    }
}
