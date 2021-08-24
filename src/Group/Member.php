<?php

namespace TimSDK\Group;

use JsonSerializable;

class Member implements JsonSerializable
{
    /**
     * @var string
     */
    protected $memberAccount;
    /**
     * @var string
     */
    protected $role;
    /**
     * @var int
     */
    protected $joinTime;
    /**
     * @var int
     */
    protected $unreadMsgNum;

    /**
     * Member constructor.
     * @param string $memberAccount
     * @param string $role
     * @param int    $joinTime
     * @param int    $unreadMsgNum
     */
    public function __construct(string $memberAccount, string $role, int $joinTime, int $unreadMsgNum)
    {
        $this->memberAccount = $memberAccount;
        $this->role = $role;
        $this->joinTime = $joinTime;
        $this->unreadMsgNum = $unreadMsgNum;
    }

    public function jsonSerialize()
    {
        return [
            'Member_Account' => $this->memberAccount,
            'Role' => $this->role,
            'JoinTime' => $this->joinTime,
            'UnreadMsgNum' => $this->unreadMsgNum,
        ];
    }
}
