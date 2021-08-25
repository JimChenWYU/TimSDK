<?php

namespace TimSDK\Auth;

use TimSDK\Kernel\UserSig as BaseUserSig;

class UserSig extends BaseUserSig
{
	protected function getCredentials(): array
	{
		return [
			'app_id' => $this->app->config->get('app_id'),
			'key'    => $this->app->config->get('key'),
		];
	}
}