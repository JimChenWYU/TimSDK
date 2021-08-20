<?php

namespace TimSDK\Kernel\DataStruct\MsgContent;

use JsonSerializable;

interface ElemInterface extends JsonSerializable
{
	/**
	 * @return string
	 */
	public function getMsgType(): string;
}