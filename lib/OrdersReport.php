<?php

namespace Zota;

/**
 * Class OrdersReport.
 */
class OrdersReport extends AbstractApiClient
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
     * @param \Zota\OrdersReportData $data
     *
     * @return \Zota\OrdersReportApiResponse
     */
    public function request($data)
    {
        // return directly mock response if available.
        $mockResponse = $this->getMockResponse();
        if (!empty($mockResponse)) {
            Zota::getLogger()->debug('Using mocked response for orders report request.', []);
            $response = new \Zota\OrdersReportApiResponse($mockResponse);
            return $response;
        }
        // setup url
        $url =  \Zota\Zota::getApiUrl() . '/query/orders-report/csv/';

        // setup data
        Zota::getLogger()->debug('Orders Report prepare post data.');
        $prepared = $this->prepare($data);
        $signed = $this->sign($prepared);

        // make the request
        Zota::getLogger()->info('Orders Report request.');
        $request = $this->apiRequest->request('get', $url, $signed);

        // set the response
        Zota::getLogger()->debug('Orders Report response.');
        $response = new \Zota\OrdersReportApiResponse($request);

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
            'merchantID'    => \Zota\Zota::getMerchantId(),
            'dateType'      => $data->getDateType(),
            'endpointIds'   => $data->getEndpointIds(),
            'fromDate'      => $data->getFromDate(),
            'requestID'     => \Zota\Helper\Helper::generateUuid(),
            'statuses'      => $data->getStatuses(),
            'timestamp'     => $this->timestamp,
            'toDate'        => $data->getToDate(),
            'types'         => $data->getTypes(),
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
            \Zota\Zota::getMerchantId(),
            $data['dateType'],
            $data['endpointIds'],
            $data['fromDate'],
            $data['requestID'],
            $data['statuses'],
            $data['timestamp'],
            $data['toDate'],
            $data['types'],
            \Zota\Zota::getMerchantSecretKey(),
        ];

        $stringToSign = implode($dataToSign);

        $data['signature'] = hash('sha256', $stringToSign);

        return $data;
    }
}
