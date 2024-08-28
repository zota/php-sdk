<?php

namespace Zota;

/**
 * @internal
 */
final class ZotaTest extends \PHPUnit\Framework\TestCase
{
    use \Zota\TestHelper;

    /** @var array */
    protected $logger;


    /**
     * Data Array
     * @return array
     */
    public static function getData()
    {
        return array();
    }


    /**
     * Get Logger
     */
    public function testGetLogger()
    {
        $logger = Zota::getLogger();

        $this->assertInstanceOf(\Zota\Log\LoggerInterface::class, $logger);
    }


    /**
     * Set Logger
     */
    public function testSetLogger()
    {
        $logger = new \Zota\Log\DefaultLogger();
        Zota::setLogger($logger);

        $this->assertSame($logger, Zota::getLogger());
    }


    /**
     * Set setApiVersion
     */
    public function testSetApiVersion()
    {
        $version = 'text_version';

        Zota::setApiVersion($version);
        $this->assertEquals($version, Zota::getApiVersion());
    }


    /**
     * Set setApiBase
     */
    public function testSetApiBase()
    {
        $url = 'https://example.com';

        Zota::setApiBase($url);
        $this->assertEquals($url, Zota::getApiBase());
        $this->assertEquals($url . '/api/' . Zota::getApiVersion(), Zota::getApiUrl());
    }


    /**
     * Set setApiUrl
     */
    public function testSetApiUrl()
    {
        $url = 'https://example.com';

        Zota::setApiUrl($url);
        $this->assertEquals($url, Zota::getApiUrl());
    }


    /**
     * Set setLogThreshold
     */
    public function testSetLogThreshold()
    {
        $treshold = 'error';

        Zota::setLogThreshold($treshold);
        $this->assertEquals($treshold, Zota::getLogThreshold());
    }


    /**
     * Set setLogDestination
     */
    public function testSetLogDestination()
    {
        $destination = dirname(__FILE__);

        Zota::setLogDestination($destination);
        $this->assertEquals($destination, Zota::getLogDestination());
    }


    /**
     * Set setMockResponse
     */
    public function testSetMockResponse()
    {
        $mockResponse = [
            '{"code":"200","message":"","data":{}}',
            200
        ];

        Zota::setMockResponse($mockResponse);
        $this->assertEquals($mockResponse, Zota::getMockResponse());
    }
}
