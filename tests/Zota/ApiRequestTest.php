<?php

namespace Zota;

/**
 * @internal
 */
final class ApiRequestTest extends \PHPUnit\Framework\TestCase
{
    public function testGetHttpClient()
    {
        $ApiRequest = new \Zota\ApiRequest();
        $this->assertInstanceOf(\Zota\HttpClient\CurlClient::class, $ApiRequest->getHttpClient());
    }

    public function testSetHttpClient()
    {
        $ApiRequest = new \Zota\ApiRequest();
        $HttpClient = new \Zota\HttpClient\CurlClient();
        $ApiRequest->setHttpClient($HttpClient);
        $this->assertSame($HttpClient, $ApiRequest->getHttpClient());
    }

    public function testRequest()
    {
        $testResponse = [
            'Test response body',
            200,
        ];

        $httpClientStub = $this->createMock(\Zota\HttpClient\CurlClient::class);
        $httpClientStub->method('request')->willReturn($testResponse);

        $ApiRequest = new \Zota\ApiRequest();
        $ApiRequest->setHttpClient($httpClientStub);

        $response = $ApiRequest->request('GET', 'http://dummy', null);
        $this->assertEquals($testResponse[0], $response[0]);
        $this->assertEquals($testResponse[1], $response[1]);
    }
}
