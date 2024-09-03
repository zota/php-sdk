<?php

namespace Zota\Exception;

/**
 * @internal
 */
final class ApiConnectionExceptionTest extends \PHPUnit\Framework\TestCase
{
    public function testException()
    {
        $this->expectException(ApiConnectException::class);

        $curlClient = new \Zota\HttpClient\CurlClient();

        $curlClientReflector = new \ReflectionClass('\Zota\HttpClient\CurlClient');

        $handleCurlError = $curlClientReflector->getMethod('handleCurlError');
        $handleCurlError->setAccessible(true);

        $handleCurlError->invoke($curlClient, '', '', '');
    }
}
