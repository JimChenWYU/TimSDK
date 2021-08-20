<?php

namespace TimSDK\Profile;

use JsonSerializable;

class Profile implements JsonSerializable
{
	/**
	 * @var string
	 */
	protected $tag;
	/**
	 * @var string
	 */
	protected $value;

	/**
	 * Profile constructor.
	 * @param string $tag
	 * @param string $value
	 */
	public function __construct(string $tag, string $value)
	{
		$this->tag = $tag;
		$this->value = $value;
	}

	public function jsonSerialize()
	{
		return [
			'Tag' => $this->tag,
			'Value' => $this->value,
		];
	}
}