<?php

namespace TimSDK\Kernel\Http;

use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

final class GuzzleMiddleware
{
	public static function retry(int $maxRetries, int $retryDelay)
	{
		return Middleware::retry(function (
			$retries,
			RequestInterface $request,
			ResponseInterface $response = null
		) use ($maxRetries) {
			// Limit the number of retries to 2
			if ($retries < $maxRetries && $response && $body = $response->getBody()) {
				// 网络错误重试
				if ($response->getStatusCode() !== 200) {
					return true;
				}
				// 业务错误重试场景
				$response = json_decode((string)$body, true);
				if (in_array($response['ErrorCode'], [
					-10007, // 验证码下发超时。
					114005, // 资源文件（如图片、文件、语音、视频）传输超时，一般是网络问题导致。

					60008, // 服务请求超时或 HTTP 请求格式错误，请检查并重试。
					60014, // 置换帐号超时。

					70169, // 服务端内部超时，请稍后重试。
					70202, // 服务端内部超时，请稍后重试。
					70500, // 服务端内部超时，请稍后重试。

					40006, // 服务端内部超时，请稍后重试。

					30006, // 服务端内部错误，请重试。
					30007, // 网络超时，请稍后重试。
					50004, // 服务端内部错误，请重试。
					50005, // 网络超时，请稍后重试。

					20004, // 网络异常，请重试。
					20005, // 服务端内部错误，请重试。
					22002, // 网络异常，请重试。
					90994, // 服务内部错误，请重试。
					90995, // 服务内部错误，请重试。
					91000, // 服务内部错误，请重试。

					10002, // 服务端内部错误，请重试。

					1003, // 系统错误。
				], true)) {
					return true;
				}
			}

			return false;
		}, function () use ($retryDelay) {
			return abs($retryDelay);
		});
	}

	public static function log(LoggerInterface $logger, ?string $logTemplate = null)
	{
		$formatter = new MessageFormatter($logTemplate ?? MessageFormatter::DEBUG);

		return Middleware::log($logger, $formatter, LogLevel::DEBUG);
	}
}