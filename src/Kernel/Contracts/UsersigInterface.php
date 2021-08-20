<?php

namespace TimSDK\Kernel\Contracts;

interface UsersigInterface
{
	/**
	 * @return string
	 */
	public function getUsersig(): string;

	/**
	 * @return UsersigInterface
	 */
	public function refresh(): self;
}