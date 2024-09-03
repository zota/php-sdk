<?php

namespace Zota\Exception;

/**
 * @internal
 */
final class InvalidRequestExceptionTest extends \PHPUnit\Framework\TestCase
{
    public function testException()
    {
        $this->expectException(InvalidRequestException::class);

        throw new \Zota\Exception\InvalidRequestException();
    }
}
