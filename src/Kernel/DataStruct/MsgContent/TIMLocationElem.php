<?php

namespace TimSDK\Kernel\DataStruct\MsgContent;

use TimSDK\Kernel\DataStruct\MsgContent\ElemInterface;

class TIMLocationElem implements ElemInterface
{
	/**
	 * @var string
	 */
	protected $desc;
	/**
	 * @var string
	 */
	protected $latitude;
	/**
	 * @var string
	 */
	protected $longitude;

	/**
	 * TIMLocationElem constructor.
	 * @param string $desc
	 * @param string $latitude
	 * @param string $longitude
	 */
	public function __construct(string $desc, string $latitude, string $longitude)
	{
		$this->desc = $desc;
		$this->latitude = $latitude;
		$this->longitude = $longitude;
	}

	public function jsonSerialize()
	{
		return [
			'Desc' => $this->desc,
			'Latitude' => $this->latitude,
			'Longitude' => $this->longitude,
		];
	}

	public function getMsgType(): string
	{
		return 'TIMLocationElem';
	}
}