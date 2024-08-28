<?php

namespace Zota\Log;

/**
 * @internal
 */
final class LogLevelsTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Data Array
     * @return array
     */
    public static function getData()
    {
        return [
            ['emergency', 8],
            ['alert', 7],
            ['critical', 6],
            ['error', 5],
            ['warning', 4],
            ['notice', 3],
            ['info', 2],
            ['debug', 1]
        ];
    }

    /**
     * \Zota\Log\LogLevels::isValidLevel()
     *
     * @dataProvider getData
     */
    public function testIsValidLevelWtihValidLevel($level, $severity)
    {
        $isValidLevel = \Zota\Log\LogLevels::isValidLevel($level);

        static::assertSame(true, $isValidLevel);
    }

    /**
     * \Zota\Log\LogLevels::isValidLevel()
     */
    public function testIsValidLevelWtihNotValidLevel()
    {
        $isValidLevel = \Zota\Log\LogLevels::isValidLevel('test');

        static::assertSame(false, $isValidLevel);
    }

    /**
     * \Zota\Log\LogLevels::getLevelSeverity()
     *
     * @dataProvider getData
     */
    public function testGetLevelSeverity($level, $severity)
    {
        $getLevelSeverity = \Zota\Log\LogLevels::getLevelSeverity($level);

        static::assertSame($severity, $getLevelSeverity);
    }
}
