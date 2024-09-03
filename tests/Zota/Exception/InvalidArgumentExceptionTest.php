<?php

namespace Zota\Exception;

/**
 * @internal
 */
final class InvalidArgumentExceptionTest extends \PHPUnit\Framework\TestCase
{
    public function testException()
    {
        $this->expectException(InvalidArgumentException::class);

        $curlClient = new \Zota\HttpClient\CurlClient();

        $curlClient->request('non-existing', '', []);
    }
}
