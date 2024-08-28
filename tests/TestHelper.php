<?php

namespace Zota;

/**
 * Helper trait.
 */
trait TestHelper
{
    /** @var null|string original merchant unique identifier */
    protected $origMerchantId;

    /** @var null|string original secret key */
    protected $origMerchantSecretKey;

    /** @var null|string original version of the Zota API */
    protected $origEndpoint;

    /** @var null|string original base URL */
    protected $origApiBase;

    /** @var null|\Zota\ApiRequest ApiRequest mock object */
    private $apiClientStub;

    /** @before */
    protected function setUpConfig()
    {
        // Save original values so that we can restore them after running tests
        $this->origMerchantId = \Zota\Zota::getMerchantId();
        $this->origMerchantSecretKey = \Zota\Zota::getMerchantSecretKey();
        $this->origEndpoint = \Zota\Zota::getEndpoint();
        $this->origApiBase = \Zota\Zota::getApiBase();

        // Set up host and credentials
        \Zota\Zota::setMerchantId('api_test_merchant_id');
        \Zota\Zota::setMerchantSecretKey('api_test_merchant_secret_key');
        \Zota\Zota::setEndpoint('api_test_endpoint');  // USD Sandbox environment
        \Zota\Zota::setApiBase('https://api.Zota-sandbox.com'); // Sandbox environment

        if (!empty(getenv('API_INTEGRATION_TESTS'))) {
            \Zota\Zota::setMerchantId(getenv('API_MERCHANT_ID'));
            \Zota\Zota::setMerchantSecretKey(getenv('API_MERCHANT_SECRET_KEY'));
            \Zota\Zota::setEndpoint('503364');  // USD Sandbox environment
            return;
        }

        $providedData = $this->getData();

        if (empty($providedData)) {
            return;
        }

        list($input, $expected) = reset($providedData);

        $responseData = [
            'code'    => $expected['code'],
            'message' => $expected['message'],
            'data'    => [
                'merchantOrderID' => $expected['merchantOrderID'] ?? null,
                'orderID'         => $expected['orderID'] ?? null,
            ],
        ];
        if (!empty($expected['status'])) {
            $responseData['data']['status'] = $expected['status'];
        }
        if (!empty($expected['depositUrl'])) {
            $responseData['data']['depositUrl'] = $expected['depositUrl'];
        }
        $response = [
            \json_encode($responseData),
            $expected['code'],
        ];

        $this->apiClientStub = $this->createMock(\Zota\ApiRequest::class);
        $this->apiClientStub->method('request')->willReturn($response);
    }

    /**
     * Data for testing mocked responses.
     *
     * @return array
     */
    public static function getMockData()
    {
        return [
            [
                // httpClientRequest
                [
                    '{"code":"200","message":"","data":{}}',
                    200
                ],

                // ref
                [
                    'httpCode' => 200,
                    'code' => 200,
                    'data' => null,
                    'message' => null,
                ]
            ],
            [
                // httpClientRequest
                [
                    '{"code":"400","message":"An error message","data":{}}',
                    400
                ],

                // ref
                [
                    'httpCode' => 400,
                    'code' => 400,
                    'data' => null,
                    'message' => 'An error message',
                ]
            ],
        ];
    }

    /** @after */
    protected function tearDownConfig()
    {
        // Restore original values
        \Zota\Zota::setMerchantId($this->origMerchantId);
        \Zota\Zota::setMerchantSecretKey($this->origMerchantSecretKey);
        \Zota\Zota::setEndpoint($this->origEndpoint);
        \Zota\Zota::setApiBase($this->origApiBase);
    }
}
