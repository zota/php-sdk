<?php

namespace Zota\Exception;

/**
 * @internal
 */
final class ApiCallbackExceptionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testException()
    {
        $this->expectException(\Zota\Exception\ApiCallbackException::class);

        \Zota\Zota::setLogThreshold('critical'); // skip errors

        new \Zota\ApiCallback();
    }
}
