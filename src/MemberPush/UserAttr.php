<?php

namespace TimSDK\MemberPush;

use JsonSerializable;

class UserAttr implements JsonSerializable
{
	/**
	 * @var string
	 */
	protected $toAccount;
	/**
	 * @var array<string, string>
	 */
	protected $attrs;

	/**
	 * UserAttr constructor.
	 * @param string   $toAccount
	 * @param string[] $attrs
	 */
	public function __construct(string $toAccount, array $attrs)
	{
		$this->toAccount = $toAccount;
		$this->attrs = $attrs;
	}

	public function jsonSerialize()
	{
		return [
			'To_Account' => $this->toAccount,
			'Attrs' => $this->attrs,
		];
	}
}