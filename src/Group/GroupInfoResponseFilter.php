<?php

namespace TimSDK\Group;

use JsonSerializable;

class GroupInfoResponseFilter implements JsonSerializable
{
	/**
	 * @var string[]
	 */
	protected $groupBaseInfoFilter;
	/**
	 * @var string[]
	 */
	protected $memberInfoFilter;
	/**
	 * @var string[]
	 */
	protected $appDefinedDataFilterGroup;
	/**
	 * @var string[]
	 */
	protected $appDefinedDataFilterGroupMember;

	/**
	 * ResponseFilter constructor.
	 * @param string[] $groupBaseInfoFilter
	 * @param string[] $memberInfoFilter
	 * @param string[] $appDefinedDataFilterGroup
	 * @param string[] $appDefinedDataFilterGroupMember
	 */
	public function __construct(
		array $groupBaseInfoFilter,
		array $memberInfoFilter,
		array $appDefinedDataFilterGroup,
		array $appDefinedDataFilterGroupMember
	) {
		$this->groupBaseInfoFilter = $groupBaseInfoFilter;
		$this->memberInfoFilter = $memberInfoFilter;
		$this->appDefinedDataFilterGroup = $appDefinedDataFilterGroup;
		$this->appDefinedDataFilterGroupMember = $appDefinedDataFilterGroupMember;
	}

	public function jsonSerialize()
	{
		return [
			'GroupBaseInfoFilter' => $this->groupBaseInfoFilter,
			'MemberInfoFilter'    => $this->memberInfoFilter,
			'AppDefinedDataFilter_Group' => $this->appDefinedDataFilterGroup,
			'AppDefinedDataFilter_GroupMember' => $this->appDefinedDataFilterGroupMember,
		];
	}
}