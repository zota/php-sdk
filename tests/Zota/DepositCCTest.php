<?php

namespace Zota;

/**
 * @internal
 */
final class DepositCCTest extends \PHPUnit\Framework\TestCase
{
    use \Zota\TestHelper;

    /**
     * Data Array
     * @return array
     */
    public static function getData()
    {
        $merchantOrderId = !empty(getenv('API_INTEGRATION_TESTS')) ? \Zota\Helper\Helper::generateUuid() : '1';

        $orderData = [
            'merchantOrderID'   => $merchantOrderId,
            'merchantOrderDesc' => 'Deposit CC test description',
            'orderAmount'       => '100.00',
            'orderCurrency'     => 'USD',
            'customerEmail'     => 'testing@Zota-api.com',
            'customerFirstName' => 'John',
            'customerLastName'  => 'Lock',
            'customerAddress'   => 'The Swan, Jungle St. 108',
            'customerCountryCode' => 'US',
            'customerCity'      => 'Los Angeles',
            'customerState'     => 'CA',
            'customerZipCode'   => '90015',
            'customerPhone'     => '+1 420-100-1000',
            'customerIP'        => '134.201.250.130',
            'customerBankCode'  => 'BBL',
            'customerBankAccountNumber' => '100200',
            'redirectUrl'       => 'http:://localhost/redirect',
            'callbackUrl'       => 'http:://localhost/callback',
            'checkoutUrl'       => 'http:://localhost/checkout',
            'customParam'       => json_encode([ 'TestCustomParam' => '123' ]),
            'language'          => 'EN',
            'cardHolderName'    => 'UNIT TEST',
            'cardNumber'        => '4222222222222222',
            'cardExpirationMonth' => '12',
            'cardExpirationYear' => (string)((int)date('y') + 1),
            'cardCvv'           => '123',
        ];

        return [
            [
                // data
                $orderData,

                // ref
                [
                    'code' => 200,
                    'message' => null,
                    'data' => [
                        'merchantOrderID' => $merchantOrderId,
                        'orderID' => '1234',
                    ],
                    'httpCode' => 200,
                    'status' => null,
                    'merchantOrderID' => $merchantOrderId,
                    'orderID' => '1234',
                    'request_signature' => '32223c63b2a478e2e1c44edd6d73c217aa4d4b5d1bb4a0672cfa5726d7d217f5',
                ]
            ]
        ];
    }


    /**
     * Deposit Credit Card Request
     *
     * @dataProvider getData
     */
    public function testRequest($order, $ref)
    {
        $depositOrder = new \Zota\DepositOrder($order);
        $deposit = new \Zota\DepositCC();
        if (!empty($this->apiClientStub)) {
            $deposit->setApiRequest($this->apiClientStub);
        }
        $response = $deposit->request($depositOrder);

        static::assertNotFalse($response);
        static::assertInstanceOf(\Zota\DepositCCApiResponse::class, $response);

        static::assertSame($ref['code'], $response->getCode());
        static::assertSame($ref['message'], $response->getMessage());
        static::assertSame($ref['httpCode'], $response->getHttpCode());

        if (empty(getenv('API_INTEGRATION_TESTS'))) {
            static::assertSame($ref['data'], $response->getData());
            static::assertSame($ref['status'], $response->getStatus());
            static::assertSame($ref['merchantOrderID'], $response->getMerchantOrderID());
            static::assertSame($ref['orderID'], $response->getOrderID());
        }
    }

    /**
     * Request prepare
     *
     * @dataProvider getData
     */
    public function testPrepare($order, $ref)
    {
        $depositOrder = new \Zota\DepositOrder($order);
        $deposit = new \Zota\DepositCC();

        $reflection = new \ReflectionClass(get_class($deposit));
        $method = $reflection->getMethod('prepare');
        $method->setAccessible(true);
        $prepare = $method->invokeArgs($deposit, array($depositOrder));

        $this->assertArrayHasKey('merchantOrderID', $prepare);
        $this->assertArrayHasKey('merchantOrderDesc', $prepare);
        $this->assertArrayHasKey('orderAmount', $prepare);
        $this->assertArrayHasKey('orderCurrency', $prepare);
        $this->assertArrayHasKey('customerEmail', $prepare);
        $this->assertArrayHasKey('customerFirstName', $prepare);
        $this->assertArrayHasKey('customerLastName', $prepare);
        $this->assertArrayHasKey('customerAddress', $prepare);
        $this->assertArrayHasKey('customerCountryCode', $prepare);
        $this->assertArrayHasKey('customerCity', $prepare);
        $this->assertArrayHasKey('customerState', $prepare);
        $this->assertArrayHasKey('customerZipCode', $prepare);
        $this->assertArrayHasKey('customerPhone', $prepare);
        $this->assertArrayHasKey('customerIP', $prepare);
        $this->assertArrayHasKey('customerBankCode', $prepare);
        $this->assertArrayHasKey('customerBankAccountNumber', $prepare);
        $this->assertArrayHasKey('redirectUrl', $prepare);
        $this->assertArrayHasKey('callbackUrl', $prepare);
        $this->assertArrayHasKey('checkoutUrl', $prepare);
        $this->assertArrayHasKey('customParam', $prepare);
        $this->assertArrayHasKey('language', $prepare);
        $this->assertArrayHasKey('cardHolderName', $prepare);
        $this->assertArrayHasKey('cardNumber', $prepare);
        $this->assertArrayHasKey('cardExpirationMonth', $prepare);
        $this->assertArrayHasKey('cardExpirationYear', $prepare);
        $this->assertArrayHasKey('cardCvv', $prepare);
    }

    /**
     * Request signing
     *
     * @dataProvider getData
     */
    public function testSign($order, $ref)
    {
        if (!empty(getenv('API_INTEGRATION_TESTS'))) {
            $this->markTestSkipped('Not aplicable in integration tests.');
        }

        $deposit = new \Zota\DepositCC();

        $reflection = new \ReflectionClass(get_class($deposit));
        $method = $reflection->getMethod('sign');
        $method->setAccessible(true);
        $signed = $method->invokeArgs($deposit, array($order));

        $this->assertEquals($ref['request_signature'], $signed['signature']);
    }

    /**
     * Test mocking respons.
     *
     * @dataProvider getMockData
     */
    public function testMockResponse($mockResponse, $ref)
    {
        \Zota\Zota::setMockResponse($mockResponse);

        $depositOrder = new \Zota\DepositOrder();
        $deposit = new \Zota\DepositCC();

        $response = $deposit->request($depositOrder);

        static::assertInstanceOf(\Zota\DepositCCApiResponse::class, $response);

        static::assertSame($ref['code'], $response->getCode());
        static::assertSame($ref['httpCode'], $response->getHttpCode());
        static::assertSame($ref['message'], $response->getMessage());

        static::assertNull($deposit->getMockResponse());
    }
}
