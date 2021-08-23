<?php

namespace TimSDK\Group;

use JsonSerializable;

class GroupInfo implements JsonSerializable
{
	/**
	 * @var string
	 */
	protected $introduction;
	/**
	 * @var string
	 */
	protected $notification;
	/**
	 * @var string
	 */
	protected $faceUrl;
	/**
	 * @var int
	 */
	protected $maxMemberCount;
	/**
	 * @var string
	 */
	protected $applyJoinOption;

	/**
	 * GroupInfo constructor.
	 * @param string $introduction
	 * @param string $notification
	 * @param string $faceUrl
	 * @param int    $maxMemberCount
	 * @param string $applyJoinOption
	 */
	public function __construct(
		string $introduction,
		string $notification,
		string $faceUrl,
		int $maxMemberCount,
		string $applyJoinOption
	) {
		$this->introduction = $introduction;
		$this->notification = $notification;
		$this->faceUrl = $faceUrl;
		$this->maxMemberCount = $maxMemberCount;
		$this->applyJoinOption = $applyJoinOption;
	}

	/**
	 * @return string
	 */
	public function getIntroduction(): string
	{
		return $this->introduction;
	}

	/**
	 * @return string
	 */
	public function getNotification(): string
	{
		return $this->notification;
	}

	/**
	 * @return string
	 */
	public function getFaceUrl(): string
	{
		return $this->faceUrl;
	}

	/**
	 * @return int
	 */
	public function getMaxMemberCount(): int
	{
		return $this->maxMemberCount;
	}

	/**
	 * @return string
	 */
	public function getApplyJoinOption(): string
	{
		return $this->applyJoinOption;
	}

	public function jsonSerialize()
	{
		return [
			'Introduction' => $this->introduction,
			'Notification' => $this->notification,
			'FaceUrl'      => $this->faceUrl,
			'MaxMemberCount' => $this->maxMemberCount,
			'ApplyJoinOption' => $this->applyJoinOption,
		];
	}
}