<?php

namespace Kernel\Traits;

use Nyholm\Psr7;
use Psr\Http\Client\ClientInterface;
use TimSDK\Kernel\Http\Client;
use TimSDK\Kernel\Http\Response;
use TimSDK\Kernel\Traits\InteractWithHttpClient;
use TimSDK\Tests\TestCase;

class InteractWithHttpClientTest extends TestCase
{
    public function testDefaultOptions()
    {
        $this->assertSame([
            'curl' => [
                CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
            ],
        ], InteractWithHttpClient::getDefaultOptions());

        InteractWithHttpClient::setDefaultOptions(['foo' => 'bar']);

        $this->assertSame(['foo' => 'bar'], InteractWithHttpClient::getDefaultOptions());
    }

    public function testHttpClient()
    {
        $cls = \Mockery::mock(InteractWithHttpClient::class);
        $this->assertInstanceOf(ClientInterface::class, $cls->getHttpClient());

        $client = \Mockery::mock(Client::class);
        $cls->setHttpClient($client);
        $this->assertSame($client, $cls->getHttpClient());
    }

    public function testRequest()
    {
        $cls = \Mockery::mock(DummnyClassForInteractWithHttpClientTest::class.'[createPsr7Request]')->makePartial();
        $client = \Mockery::mock(Client::class);
        $cls->setHttpClient($client);
        $request = new Psr7\Request('GET', 'foo/bar', [], null, '1.1');
        $response = new Response(200, [], 'mock-result');

        $cls->expects()->createPsr7Request('GET', 'foo/bar', [], null, '1.1')->andReturn($request);
        $client->expects()->sendRequest($request)->andReturn($response);
        $this->assertSame($response, $cls->request('foo/bar', 'GET'));

        $request1 = new Psr7\Request('POST', 'foo/bar');
        $request2 = new Psr7\Request($request1->getMethod(), (string)$request1->getUri()->withQuery('foo=bar'));
        $cls->expects()->createPsr7Request('POST', 'foo/bar', [], null, '1.1')->andReturn($request1);
        $cls->expects()->createPsr7Request('POST', 'foo/bar?foo=bar', [], null, '1.1')->andReturn($request2);

        $client->expects()->sendRequest($request2)->andReturn($response);

        $this->assertSame($response, $cls->request('foo/bar', 'POST', [
            'query' => ['foo' => 'bar']
        ]));
    }

    public function testFixJsonIssue()
    {
        $cls = \Mockery::mock(DummnyClassForInteractWithHttpClientTest::class.'[createPsr7Request]')->makePartial();

        $client = \Mockery::mock(Client::class);
        $cls->setHttpClient($client);

        $response = new Response(200, [], 'mock-result');
        $request = new Psr7\Request('POST', 'foo/bar', [
            'Content-Type' => 'application/json',
        ], '{}');
        $cls->expects()->createPsr7Request('POST', 'foo/bar', [
            'Content-Type' => 'application/json'
        ], '{}', '1.1')->andReturn($request);
        // default arguments
        $client->expects()->sendRequest($request)->andReturn($response);

        $this->assertSame($response, $cls->request('foo/bar', 'POST', [
            'json' => [],
        ]));

        // unescape unicode
        $request = new Psr7\Request('POST', 'foo/bar', [
            'Content-Type' => 'application/json',
        ], '{"name":"中文"}');
        $cls->expects()->createPsr7Request('POST', 'foo/bar', [
            'Content-Type' => 'application/json'
        ], '{"name":"中文"}', '1.1')->andReturn($request);
        $client->expects()->sendRequest($request)->andReturn($response);
        $this->assertSame($response, $cls->request('foo/bar', 'POST', [
            'json' => ['name' => '中文'],
        ]));
    }
}

class DummnyClassForInteractWithHttpClientTest
{
    use InteractWithHttpClient;

    protected $baseUri = 'http://tim-sdk.com';
}
