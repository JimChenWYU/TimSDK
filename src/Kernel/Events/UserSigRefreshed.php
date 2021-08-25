<?php

namespace TimSDK\Kernel\Events;

use TimSDK\Kernel\UserSig;

class UserSigRefreshed
{
    /**
     * @var \TimSDK\Kernel\UserSig
     */
    public $userSig;

    public function __construct(UserSig $userSig)
    {
        $this->userSig = $userSig;
    }
}
