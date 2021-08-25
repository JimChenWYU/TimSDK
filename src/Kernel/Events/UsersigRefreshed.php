<?php

namespace TimSDK\Kernel\Events;

use TimSDK\Kernel\UserSig;

class UsersigRefreshed
{
	/**
	 * @var \TimSDK\Kernel\UserSig
	 */
	public $usersig;

	public function __construct(UserSig $usersig)
	{
		$this->usersig = $usersig;
	}
}