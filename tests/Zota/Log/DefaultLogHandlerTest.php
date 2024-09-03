<?php

namespace Zota\Log;

/**
 * @internal
 */
final class DefaultLogHandlerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Data Array
     * @return array
     */
    public static function getData()
    {
        return [
            [0, 'emergency', 'Test {message}', ['message' => 'Emergency'], '1970-01-01T00:00:00+00:00 EMERGENCY Test Emergency'],
            [0, 'alert','Test {message}', ['message' => 'Alert'], '1970-01-01T00:00:00+00:00 ALERT Test Alert'],
            [0, 'critical','Test {message}', ['message' => 'Critical'], '1970-01-01T00:00:00+00:00 CRITICAL Test Critical'],
            [0, 'error','Test {message}', ['message' => 'Error'], '1970-01-01T00:00:00+00:00 ERROR Test Error'],
            [0, 'warning','Test {message}', ['message' => 'Warning'], '1970-01-01T00:00:00+00:00 WARNING Test Warning'],
            [0, 'notice','Test {message}', ['message' => 'Notice'], '1970-01-01T00:00:00+00:00 NOTICE Test Notice'],
            [0, 'info','Test {message}', ['message' => 'Info'], '1970-01-01T00:00:00+00:00 INFO Test Info'],
            [0, 'debug','Test {message}', ['message' => 'Debug'], '1970-01-01T00:00:00+00:00 DEBUG Test Debug']
        ];
    }

    /**
     * \Zota\Log\DefaultLogHandler::handle()
     *
     * @dataProvider getData
     */
    public function testHandle($timestamp, $level, $message, $context)
    {
        $handler = new \Zota\Log\DefaultLogHandler();

        static::assertSame(true, $handler->handle($timestamp, $level, $message, $context));
    }

    /**
     * \Zota\Log\DefaultLogHandler::handle()
     *
     * @dataProvider getData
     */
    public function testHandleWithLogDestination($timestamp, $level, $message, $context)
    {
        $logDestination = dirname(__FILE__, 3) . '/test.log';
        \Zota\Zota::setLogDestination($logDestination);

        $handler = new \Zota\Log\DefaultLogHandler();

        static::assertSame(true, $handler->handle($timestamp, $level, $message, $context));

        \Zota\Zota::setLogDestination(null);
        if (\touch($logDestination)) {
            \unlink($logDestination);
        }
    }

    /**
     * \Zota\Log\DefaultLogHandler::formatEntry()
     *
     * @dataProvider getData
     */
    public function testformatEntry($timestamp, $level, $message, $context, $formatted)
    {
        $formatEntry = \Zota\Log\DefaultLogHandler::formatEntry($timestamp, $level, $message, $context);

        static::assertSame($formatted, $formatEntry);
    }
}
