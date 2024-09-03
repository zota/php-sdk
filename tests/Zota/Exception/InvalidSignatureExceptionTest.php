<?php

namespace Zota\Exception;

/**
 * @internal
 */
final class InvalidSignatureExceptionTest extends \PHPUnit\Framework\TestCase
{
    public function testException()
    {
        $this->expectException(\Zota\Exception\InvalidSignatureException::class);

        throw new \Zota\Exception\InvalidSignatureException();
    }
}
