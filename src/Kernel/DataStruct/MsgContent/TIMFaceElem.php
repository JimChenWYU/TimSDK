<?php

namespace TimSDK\Kernel\DataStruct\MsgContent;

use TimSDK\Kernel\DataStruct\MsgContent\ElemInterface;

class TIMFaceElem implements ElemInterface
{
	/**
	 * @var int
	 */
	protected $index;
	/**
	 * @var string
	 */
	protected $data;

	/**
	 * TIMFaceElem constructor.
	 * @param int    $index
	 * @param string $data
	 */
	public function __construct(int $index, string $data)
	{
		$this->index = $index;
		$this->data = $data;
	}

	public function jsonSerialize()
	{
		return [
			'Index' => $this->index,
			'Data'  => $this->data,
		];
	}

	public function getMsgType(): string
	{
		return 'TIMFaceElem';
	}
}