<?php

namespace TimSDK\Account;

use JsonSerializable;

class AccountItem implements JsonSerializable
{
	/**
	 * @var string
	 */
	protected $userId;

	/**
	 * CheckItem constructor.
	 * @param string $userId
	 */
	public function __construct(string $userId)
	{
		$this->userId = $userId;
	}

	/**
	 * @return string
	 */
	public function getUserId(): string
	{
		return $this->userId;
	}

	public function jsonSerialize()
	{
		return [
			'UserID' => $this->userId
		];
	}
}