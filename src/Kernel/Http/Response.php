<?php

namespace TimSDK\Kernel\Http;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Psr\Http\Message\ResponseInterface;
use TimSDK\Kernel\Support\Collection;

class Response extends GuzzleResponse
{
	/**
	 * @return string
	 */
	public function getBodyContents()
	{
		$this->getBody()->rewind();
		$contents = $this->getBody()->getContents();
		$this->getBody()->rewind();

		return $contents;
	}

	/**
	 * @return Response
	 */
	public static function buildFromPsrResponse(ResponseInterface $response)
	{
		return new static(
			$response->getStatusCode(),
			$response->getHeaders(),
			$response->getBody(),
			$response->getProtocolVersion(),
			$response->getReasonPhrase()
		);
	}

	/**
	 * Build to json.
	 *
	 * @return string
	 */
	public function toJson()
	{
		return json_encode($this->toArray());
	}

	/**
	 * Build to array.
	 *
	 * @return array
	 */
	public function toArray()
	{
		$content = $this->removeControlCharacters($this->getBodyContents());

		// TODO: xml parse

		$array = json_decode($content, true, 512, JSON_BIGINT_AS_STRING);

		if (JSON_ERROR_NONE === json_last_error()) {
			return (array)$array;
		}

		return [];
	}

	/**
	 * Get collection data.
	 *
	 * @return Collection
	 */
	public function toCollection()
	{
		return new Collection($this->toArray());
	}

	/**
	 * @return object
	 */
	public function toObject()
	{
		return json_decode($this->toJson());
	}

	/**
	 * @return bool|string
	 */
	public function __toString()
	{
		return $this->getBodyContents();
	}

	/**
	 * @return string
	 */
	protected function removeControlCharacters(string $content)
	{
		return preg_replace('/[\x00-\x1F\x80-\x9F]/u', '', $content);
	}
}