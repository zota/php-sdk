<?php

namespace Zota\Log;

/**
 * @internal
 */
final class DefaultLoggerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Data Array
     * @return array
     */
    public static function getData()
    {
        return [
            ['emergency', 'Test {message}', ['message' => 'Emergency']],
            ['alert','Test {message}', ['message' => 'Alert']],
            ['critical','Test {message}', ['message' => 'Critical']],
            ['error','Test {message}', ['message' => 'Error']],
            ['warning','Test {message}', ['message' => 'Warning']],
            ['notice','Test {message}', ['message' => 'Notice']],
            ['info','Test {message}', ['message' => 'Info']],
            ['debug','Test {message}', ['message' => 'Debug']]
        ];
    }

    /**
     * \Zota\Log\DefaultLogger::log()
     *
     * @dataProvider getData
     */
    public function testLog($level, $message, $context)
    {
        $defaultLogger = new \Zota\Log\DefaultLogger();
        $log = $defaultLogger->log($level, $message, $context);
        $this->assertSame(true, $log);
    }


    /**
     * \Zota\Log\DefaultLogger::__construct()
     */
    public function testConstructorWithNotValidThreshold()
    {
        $defaultLogger = new \Zota\Log\DefaultLogger(-1);

        $tresholdReflection = new \ReflectionProperty(\Zota\Log\DefaultLogger::class, 'threshold');
        $tresholdReflection->setAccessible(true);

        $this->assertSame(0, $tresholdReflection->getValue($defaultLogger));
    }


    /**
     * \Zota\Log\DefaultLogger::log()
     */
    public function testLogWithNotValidLevel()
    {
        $this->expectException(\Zota\Exception\InvalidArgumentException::class);

        $defaultLogger = new \Zota\Log\DefaultLogger();
        $defaultLogger->log('not-valid-level', 'Test with not valid Level');
    }

    /**
     * \Zota\Log\DefaultLogger::emergency()
     */
    public function testEmergency()
    {
        $defaultLogger = new \Zota\Log\DefaultLogger();
        $log = $defaultLogger->emergency('Test Emergency');
        $this->assertSame(true, $log);
    }

    /**
     * \Zota\Log\DefaultLogger::alert()
     */
    public function testAlert()
    {
        $defaultLogger = new \Zota\Log\DefaultLogger();
        $log = $defaultLogger->alert('Test Alert');
        $this->assertSame(true, $log);
    }

    /**
     * \Zota\Log\DefaultLogger::critical()
     */
    public function testCritical()
    {
        $defaultLogger = new \Zota\Log\DefaultLogger();
        $log = $defaultLogger->critical('Test Critical');
        $this->assertSame(true, $log);
    }

    /**
     * \Zota\Log\DefaultLogger::error()
     */
    public function testError()
    {
        $defaultLogger = new \Zota\Log\DefaultLogger();
        $log = $defaultLogger->error('Test Error');
        $this->assertSame(true, $log);
    }

    /**
     * \Zota\Log\DefaultLogger::warning()
     */
    public function testWarning()
    {
        $defaultLogger = new \Zota\Log\DefaultLogger();
        $log = $defaultLogger->warning('Test Warning');
        $this->assertSame(true, $log);
    }

    /**
     * \Zota\Log\DefaultLogger::notice()
     */
    public function testNotice()
    {
        $defaultLogger = new \Zota\Log\DefaultLogger();
        $log = $defaultLogger->notice('Test Notice');
        $this->assertSame(true, $log);
    }

    /**
     * \Zota\Log\DefaultLogger::info()
     */
    public function testInfo()
    {
        $defaultLogger = new \Zota\Log\DefaultLogger();
        $log = $defaultLogger->info('Test Info');
        $this->assertSame(true, $log);
    }

    /**
     * \Zota\Log\DefaultLogger::debug()
     */
    public function testDebug()
    {
        $defaultLogger = new \Zota\Log\DefaultLogger();
        $log = $defaultLogger->debug('Test Debug');
        $this->assertSame(true, $log);
    }
}
