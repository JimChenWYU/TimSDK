<?php

namespace TimSDK\Group;

use JsonSerializable;

class MsgSeq implements JsonSerializable
{
	/**
	 * @var string
	 */
	protected $msgSeq;

	/**
	 * MsgSeq constructor.
	 * @param string $msgSeq
	 */
	public function __construct(string $msgSeq)
	{
		$this->msgSeq = $msgSeq;
	}

	/**
	 * @return string
	 */
	public function getMsgSeq(): string
	{
		return $this->msgSeq;
	}

	public function jsonSerialize()
	{
		return [
			'MsgSeq' => $this->msgSeq,
		];
	}
}