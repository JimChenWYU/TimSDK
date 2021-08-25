<?php

namespace TimSDK\Kernel\Traits;

trait InteractWithIdentifier
{
	/**
	 * @var string
	 */
	protected $identifier;

	/**
	 * @return string
	 */
	public function getIdentifier(): string
	{
		if ($this->identifier) {
			return $this->identifier;
		}

		$defaultAdmin = 'administrator';

		if (property_exists($this, 'app')) {
			return $this->app['config']->get('identifier', $defaultAdmin);
		}

		return $defaultAdmin;
	}

	/**
	 * @param string $identifier
	 * @return $this
	 */
	public function setIdentifier(string $identifier): self
	{
		$this->identifier = $identifier;

		return $this;
	}
}