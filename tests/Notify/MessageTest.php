<?php

namespace TimSDK\Tests\Notify;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TimSDK\Tests\TestCase;
use TimSDK\Notify;

class MessageTest extends TestCase
{
	public function testMessageNotify()
	{
		$app = $this->app();
		$uri = '?'.http_build_query([
			'SdkAppid' => '888888'
		]);
		$app['request'] = Request::create($uri, 'POST', [], [], [], [], '{
"foo":"bar"
}');
		$notify = new Notify\Message($app);

		$that = $this;
		$response = $notify->handle(function ($message, $query) use ($that) {
			$that->assertSame([
				'foo' => 'bar'
			], $message);

			$that->assertSame([
				'SdkAppid' => '888888'
			], $query);

			return true;
		});

		$this->assertInstanceOf(Response::class, $response);

		// return true.
		$this->assertSame([
			'ActionStatus' => 'OK',
			'ErrorCode' => 0,
			'ErrorInfo' => '',
		], json_decode($response->getContent(), true));

		// return false.
		$response = $notify->handle(function () {
			return false;
		});
		$this->assertSame([
			'ActionStatus' => 'OK',
			'ErrorCode' => 1,
			'ErrorInfo' => '',
		], json_decode($response->getContent(), true));

		// empty return.
		$response = $notify->handle(function () {
		});
		$this->assertSame([
			'ActionStatus' => 'OK',
			'ErrorCode' => 1,
			'ErrorInfo' => '',
		], json_decode($response->getContent(), true));

		$response = $notify->handle(function ($msg, $query, $fail) {
			$fail('fails.', 10001);
		});
		$this->assertSame([
			'ActionStatus' => 'OK',
			'ErrorCode' => 10001,
			'ErrorInfo' => 'fails.',
		], json_decode($response->getContent(), true));
	}
}