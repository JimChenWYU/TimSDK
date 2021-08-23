<?php

namespace TimSDK;

use TimSDK\Kernel\ServiceContainer;

/**
 * Class Application
 *
 * @property \TimSDK\Account\Client $account
 * @property \TimSDK\Openim\Client  $openim
 * @property \TimSDK\MemberPush\Client $member_push
 * @property \TimSDK\Profile\Client $profile
 * @property \TimSDK\Sns\Client     $sns
 * @property \TimSDK\Group\Client   $group
 * @property \TimSDK\Overall\Client $overall
 * @property \TimSDK\Operate\Client $operate
 */
class Application extends ServiceContainer
{
	protected $providers = [
		Account\ServiceProvider::class,
		Openim\ServiceProvider::class,
		MemberPush\ServiceProvider::class,
		Profile\ServiceProvider::class,
		Sns\ServiceProvider::class,
		Group\ServiceProvider::class,
		Overall\ServiceProvider::class,
		Operate\ServiceProvider::class,
	];
}
