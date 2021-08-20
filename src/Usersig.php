<?php

namespace TimSDK;

use TimSDK\Kernel\Usersig as BaseUsersig;

class Usersig extends BaseUsersig
{
	protected function getCredentials(): array
	{
		return [
			'app_id' => $this->app['config']->get('app_id'),
			'key'    => $this->app['config']->get('key'),
		];
	}
}