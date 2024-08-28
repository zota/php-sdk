<?php

namespace Zota;

/**
 * @internal
 */
final class ApiCallbackTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Data Array
     * @return array
     */
    public static function getData()
    {
        $stream = dirname(__FILE__, 2) . '/callback.json';
        $fileContents = \file_get_contents($stream);
        $data = \json_decode($fileContents, JSON_OBJECT_AS_ARRAY);

        return [
            [
                [
                    'stream' => $stream,
                    'data' => $data,
                ],
            ],
        ];
    }


    /**
     * Callback Request with data
     *
     * @dataProvider getData
     */
    public function testCallbackWithData($data)
    {
        \Zota\Zota::setMerchantSecretKey('EXAMPLE-SECRET-KEY');
        $apiCallback = new \Zota\ApiCallback($data['stream']);

        $dataArray = $data['data'];

        // test getters
        static::assertSame($dataArray['type'], $apiCallback->getType());
        static::assertSame($dataArray['status'], $apiCallback->getStatus());
        static::assertSame($dataArray['errorMessage'], $apiCallback->getErrorMessage());
        static::assertSame($dataArray['endpointID'], $apiCallback->getEndpointID());
        static::assertSame($dataArray['processorTransactionID'], $apiCallback->getProcessorTransactionID());
        static::assertSame($dataArray['orderID'], $apiCallback->getOrderID());
        static::assertSame($dataArray['merchantOrderID'], $apiCallback->getMerchantOrderID());
        static::assertSame($dataArray['amount'], $apiCallback->getAmount());
        static::assertSame($dataArray['currency'], $apiCallback->getCurrency());
        static::assertSame($dataArray['customerEmail'], $apiCallback->getCustomerEmail());
        static::assertSame($dataArray['customParam'], $apiCallback->getCustomParam());
        static::assertSame($dataArray['extraData'], $apiCallback->getExtraData());
        static::assertSame($dataArray['originalRequest'], $apiCallback->getOriginalRequest());
        static::assertSame($dataArray['signature'], $apiCallback->getSignature());
    }


    /**
     * Callback Request without  data
     *
     * @runInSeparateProcess
     */
    public function testCallbackWithoutData()
    {
        \Zota\Zota::setLogThreshold('critical');
        $this->expectException(\Zota\Exception\ApiCallbackException::class);
        $apiCallback = new \Zota\ApiCallback(null);
    }


    /**
     * Callback Request with wrong data / not valid JSON
     *
     * @runInSeparateProcess
     */
    public function testCallbackWithWrongData()
    {
        \Zota\Zota::setLogThreshold('critical');
        $this->expectException(\Zota\Exception\ApiCallbackException::class);
        $apiCallback = new \Zota\ApiCallback(__FILE__);
    }


    /**
     * Signature Verify
     *
     * @dataProvider getData
     */
    public function testSignatureVerify($data)
    {
        \Zota\Zota::setMerchantSecretKey('EXAMPLE-SECRET-KEY');

        $apiCallback = new \Zota\ApiCallback($data['stream']);

        $apiCallbackReflector = new \ReflectionClass('\Zota\ApiCallback');

        $signatureVerify = $apiCallbackReflector->getMethod('signatureVerify');
        $signatureVerify->setAccessible(true);
        $signature = $signatureVerify->invoke($apiCallback, $data['data'], '', '');

        $this->assertTrue($signature);
    }


    /**
     * Signature Verify with wrong Merchant Secret Key
     *
     * @runInSeparateProcess
     * @dataProvider getData
     */
    public function testSignatureVerifyWithWrongSignature($data)
    {
        \Zota\Zota::setLogThreshold('critical');
        \Zota\Zota::setMerchantSecretKey('WRONG-SECRET-KEY');
        $this->expectException(\Zota\Exception\InvalidSignatureException::class);
        $apiCallback = new \Zota\ApiCallback($data['stream']);
    }


    /**
     * Signature Verify without signature
     *
     * @dataProvider getData
     */
    public function testSignatureVerifyWithoutSignature($data)
    {
        \Zota\Zota::setMerchantSecretKey('EXAMPLE-SECRET-KEY');

        $apiCallback = new \Zota\ApiCallback($data['stream']);

        $apiCallbackReflector = new \ReflectionClass('\Zota\ApiCallback');

        $signatureVerify = $apiCallbackReflector->getMethod('signatureVerify');
        $signatureVerify->setAccessible(true);

        unset($data['data']['signature']);
        $signature = $signatureVerify->invoke($apiCallback, $data['data'], '', '');

        $this->assertFalse($signature);
    }
}
