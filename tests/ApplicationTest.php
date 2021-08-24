<?php

namespace TimSDK\Tests;

use TimSDK\Application;

class ApplicationTest extends TestCase
{
    public function testInstances()
    {
        $app = new Application([
            'app_id' => 'app_id-1',
            'key' => 'key-1',
            'identifier' => 'admin-1',
        ]);

		$this->assertInstanceOf(\TimSDK\Kernel\Config::class, $app->config);
		$this->assertInstanceOf(\TimSDK\Kernel\Log\LogManager::class, $app->log);
		$this->assertInstanceOf(\TimSDK\Kernel\Log\LogManager::class, $app->logger);
		$this->assertSame($app->log, $app->logger);
		$this->assertInstanceOf(\GuzzleHttp\Client::class, $app->http_client);
		$this->assertInstanceOf(\Symfony\Component\HttpFoundation\Request::class, $app->request);
		$this->assertInstanceOf(\TimSDK\Kernel\Usersig::class, $app->usersig);

		$this->assertInstanceOf(\TimSDK\Account\Client::class, $app->account);
		$this->assertInstanceOf(\TimSDK\Openim\Client::class, $app->openim);
		$this->assertInstanceOf(\TimSDK\MemberPush\Client::class, $app->member_push);
		$this->assertInstanceOf(\TimSDK\Profile\Client::class, $app->profile);
		$this->assertInstanceOf(\TimSDK\Sns\Client::class, $app->sns);
		$this->assertInstanceOf(\TimSDK\Group\Client::class, $app->group);
		$this->assertInstanceOf(\TimSDK\Overall\Client::class, $app->overall);
		$this->assertInstanceOf(\TimSDK\Operate\Client::class, $app->operate);
	}
}