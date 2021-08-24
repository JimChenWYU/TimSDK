<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 6/13/2018
 * Time: 8:17 PM
 */

namespace TimSDK\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use TimSDK\Application;
use TimSDK\Kernel\ServiceContainer;

class TestCase extends BaseTestCase
{
    protected function app()
    {
        return new Application([
            'app_id' => 'app_id-1',
            'key' => 'key-1',
            'identifier' => 'admin-1',
        ]);
    }

    /**
     * Create API Client mock object.
     *
     * @param string                                   $name
     * @param array|string                             $methods
     * @param \TimSDK\Kernel\ServiceContainer|null $app
     *
     * @return \Mockery\Mock
     */
    public function mockApiClient($name, $methods = [], ServiceContainer $app = null)
    {
        $methods = implode(',', array_merge([
            'httpGet', 'httpPost', 'httpPostJson', 'request', 'registerMiddlewares', 'castRequestQuery',
        ], (array) $methods));

        $client = \Mockery::mock(
            $name."[{$methods}]",
            [ $app ?? \Mockery::mock(ServiceContainer::class), ]
        )->shouldAllowMockingProtectedMethods();
        $client->allows()->registerHttpMiddlewares()->andReturnNull();

        return $client;
    }

    /**
     * Tear down the test case.
     */
    public function tearDown(): void
    {
        $this->finish();
        parent::tearDown();
        if ($container = \Mockery::getContainer()) {
            $this->addToAssertionCount($container->Mockery_getExpectationCount());
        }
        \Mockery::close();
    }

    /**
     * Run extra tear down code.
     */
    protected function finish()
    {
        // call more tear down methods
    }
}
