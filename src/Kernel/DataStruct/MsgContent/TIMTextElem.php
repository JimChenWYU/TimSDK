<?php

namespace TimSDK\Kernel\DataStruct\MsgContent;

use TimSDK\Kernel\DataStruct\MsgContent\ElemInterface;

class TIMTextElem implements ElemInterface
{
	/**
	 * @var string
	 */
	protected $text;

	/**
	 * TIMTextElem constructor.
	 * @param string $text
	 */
	public function __construct(string $text)
	{
		$this->text = $text;
	}

	public function jsonSerialize()
	{
		return [
			'Text' => $this->text,
		];
	}

	public function getMsgType(): string
	{
		return 'TIMTextElem';
	}
}