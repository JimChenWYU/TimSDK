<?php

namespace TimSDK\Kernel\Events;

use TimSDK\Kernel\Usersig;

class UsersigRefreshed
{
    /**
     * @var \TimSDK\Kernel\Usersig
     */
    public $usersig;

    public function __construct(Usersig $usersig)
    {
        $this->usersig = $usersig;
    }
}
