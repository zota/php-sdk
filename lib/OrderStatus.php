<?php

namespace Zota;

/**
 * Class OrderStatus.
 */
class OrderStatus extends AbstractApiClient
{
    /**
     * request timestamp
     *
     * @var null|string
     */
    protected $timestamp;


    /**
     * Class constructor.
     *
     * @param \Zota\Data $data
     */
    public function __construct($data = null)
    {
        parent::__construct();

        $this->timestamp = \time();
    }


    /**
     * Make an order status request to Zota API.
     *
     * @param \Zota\OrderStatusData $data
     *
     * @return \Zota\OrderStatusApiResponse
     */
    public function request($data)
    {
        // return directly mock response if available.
        $mockResponse = $this->getMockResponse();
        if (!empty($mockResponse)) {
            Zota::getLogger()->debug('Using mocked response for order status request.', []);
            $response = new \Zota\OrderStatusApiResponse($mockResponse);
            return $response;
        }
        // setup url
        $url =  \Zota\Zota::getApiUrl() . '/query/order-status/';

        // setup data
        // @codingStandardsIgnoreStart
        Zota::getLogger()->debug('merchantOrderID #{merchantOrderID} Order Status prepare post data.', ['merchantOrderID' => $data->getMerchantOrderID()]);
        // @codingStandardsIgnoreEnd
        $prepared = $this->prepare($data);
        $signed = $this->sign($prepared);

        // make the request
        Zota::getLogger()->info('Order Status request.');
        $request = $this->apiRequest->request('get', $url, $signed);

        // set the response
        // @codingStandardsIgnoreStart
        Zota::getLogger()->debug('merchantOrderID #{merchantOrderID} Order Status response.', ['merchantOrderID' => $data->getMerchantOrderID()]);
        // @codingStandardsIgnoreEnd                
        $response = new \Zota\OrderStatusApiResponse($request);

        return $response;
    }


    /**
     * @param \Zota\OrderStatusData $data
     *
     * @return array
     */
    private function prepare($data)
    {
        return [
            'merchantID'        => \Zota\Zota::getMerchantId(),
            'merchantOrderID'   => $data->getMerchantOrderID(),
            'orderID'           => $data->getOrderID(),
            'timestamp'         => $this->timestamp,
        ];
    }


    /**
     * @param array $data
     *
     * @return array
     */
    private function sign($data)
    {
        $dataToSign = [
            $data['merchantID'],
            $data['merchantOrderID'],
            $data['orderID'],
            $data['timestamp'],
            \Zota\Zota::getMerchantSecretKey(),
        ];

        $stringToSign = implode($dataToSign);

        $data['signature'] = hash('sha256', $stringToSign);

        return $data;
    }
}
