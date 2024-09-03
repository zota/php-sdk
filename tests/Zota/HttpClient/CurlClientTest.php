<?php

namespace Zota\HttpClient;

/**
 * @internal
 */
final class CurlClientTest extends \PHPUnit\Framework\TestCase
{
    public function testRequest()
    {
        if (empty(getenv('API_INTEGRATION_TESTS'))) {
            $this->markTestSkipped('No external requests in unit tests.');
        }

        $ref = [
            '',
            200
        ];

        $curlClient = new CurlClient();
        $request = $curlClient->request('get', 'https://httpbin.org/status/200', []);

        static::assertSame($ref, $request);
    }

    public function testResetCurlHandle()
    {
        $curlClient = new CurlClient();

        $curlClientReflector = new \ReflectionClass(\Zota\HttpClient\CurlClient::class);

        $curlHandleReflection = new \ReflectionProperty(\Zota\HttpClient\CurlClient::class, 'curlHandle');
        $curlHandleReflection->setAccessible(true);

        $initCurlHandle = $curlClientReflector->getMethod('initCurlHandle');
        $initCurlHandle->setAccessible(true);
        $initCurlHandle->invoke($curlClient, '', '', '');

        $resetCurlHandle = $curlClientReflector->getMethod('resetCurlHandle');
        $resetCurlHandle->setAccessible(true);
        $resetCurlHandle->invoke($curlClient, '', '', '');

        static::assertNotNull($curlHandleReflection);
    }

    public function testHandleCurlError()
    {
        $this->expectException(\Zota\Exception\ApiConnectException::class);

        $curlClient = new \Zota\HttpClient\CurlClient();

        $curlClientReflector = new \ReflectionClass('\Zota\HttpClient\CurlClient');

        $handleCurlError = $curlClientReflector->getMethod('handleCurlError');
        $handleCurlError->setAccessible(true);

        $handleCurlError->invoke($curlClient, '', '', '');
    }
}
