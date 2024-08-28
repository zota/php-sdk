<?php

namespace Zota;

/**
 * Abstarct Class AbstractApiClient.
 */
abstract class AbstractApiClient implements ApiClientInterface
{
    /**
     * ApiRequest instance
     *
     * @var \Zota\ApiRequest
     */
    protected $apiRequest;


    /**
     * @param \Zota\Data $data
     */
    public function __construct($data = null)
    {
        // Get the ApiRequest object
        $this->apiRequest = new \Zota\ApiRequest();
    }


    /**
     * Zota API request.
     *
     * @codeCoverageIgnore
     *
     * @param \Zota\Data $data
     *
     * @return self
     */
    public function request($data)
    {
    }


    /**
     * Prepare data for the request.
     *
     * @codeCoverageIgnore
     *
     * @param \Zota\ZotaOrder $order
     *
     * @return array
     */
    private function prepare($order)
    {
    }


    /**
     * Generate signature and add it to the data.
     *
     * @codeCoverageIgnore
     *
     * @param array $data
     *
     * @return array
     */
    private function sign($data)
    {
    }


    /**
     * Set ApiResponse onject
     *
     * @return self
     */
    public function setApiRequest($apiRequest)
    {
        $this->apiRequest = $apiRequest;
        return $this;
    }

    /**
     * Get mock response data if available.
     *
     * @return array
     */
    public function getMockResponse()
    {
        $mockResponse = \Zota\Zota::getMockResponse();
        if (!empty($mockResponse)) {
            \Zota\Zota::setMockResponse(null);
        }

        return $mockResponse;
    }
}
