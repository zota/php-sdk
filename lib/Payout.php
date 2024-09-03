<?php

namespace Zota;

/**
 * Class Payout.
 */
class Payout extends AbstractApiClient
{
    /**
     * Make a payout request to Zota API.
     *
     * @param PayoutOrder $order
     *
     * @return \Zota\PayoutApiResponse
     */
    public function request($order)
    {
        // return directly mock response if available.
        $mockResponse = $this->getMockResponse();
        if (!empty($mockResponse)) {
            Zota::getLogger()->debug('Using mocked response for payout request.', []);
            $response = new \Zota\PayoutApiResponse($mockResponse);
            return $response;
        }

        // setup url
        $url =  \Zota\Zota::getApiUrl() .
                '/payout/request/' .
                \Zota\Zota::getEndpoint();

        // setup data
        Zota::getLogger()->debug('merchantOrderID #{merchantOrderID} Payout prepare post data.', ['merchantOrderID' => $order->getMerchantOrderID()]);
        $data = $this->prepare($order);
        $signed = $this->sign($data);

        // make the request
        Zota::getLogger()->info('Payout request.');
        $request = $this->apiRequest->request('post', $url, $signed);

        // set the response
        Zota::getLogger()->debug('merchantOrderID #{merchantOrderID} Payout response.', ['merchantOrderID' => $order->getMerchantOrderID()]);
        $response = new \Zota\PayoutApiResponse($request);

        return $response;
    }


     /**
      * @param PayoutOrder $order
      *
      * @return array
      */
    private function prepare($order)
    {
        return [
           'merchantOrderID'   => $order->getMerchantOrderID(),
           'merchantOrderDesc' => $order->getMerchantOrderDesc(),
           'orderAmount'       => $order->getOrderAmount(),
           'orderCurrency'     => $order->getOrderCurrency(),
           'customerEmail'     => $order->getCustomerEmail(),
           'customerFirstName' => $order->getCustomerFirstName(),
           'customerLastName'  => $order->getCustomerLastName(),
           'customerPhone'     => $order->getCustomerPhone(),
           'customerIP'        => $order->getCustomerIP(),
           'customerBankCode'  => $order->getCustomerBankCode(),
           'customerBankAccountNumber' => $order->getCustomerBankAccountNumber(),
           'customerBankAccountName'  => $order->getCustomerBankAccountName(),
           'customerBankBranch'  => $order->getCustomerBankBranch(),
           'customerBankAddress'  => $order->getCustomerBankAddress(),
           'customerBankZipCode'  => $order->getCustomerBankZipCode(),
           'customerBankRoutingNumber'  => $order->getCustomerBankRoutingNumber(),
           'customerBankProvince'  => $order->getCustomerBankProvince(),
           'customerBankArea'  => $order->getCustomerBankArea(),
           'callbackUrl'       => $order->getCallbackUrl(),
           'customParam'       => $order->getCustomParam(),
           'language'          => $order->getLanguage(),
           'customerCountryCode'  => $order->getCustomerCountryCode(),
           'customerPersonalID'  => $order->getCustomerPersonalID(),
           'customerBankAccountNumberDigit' => $order->getCustomerBankAccountNumberDigit(),
           'customerBankAccountType'  => $order->getCustomerBankAccountType(),
           'customerBankSwiftCode'       => $order->getCustomerBankSwiftCode(),
           'customerBankBranchDigit'       => $order->getCustomerBankBranchDigit(),
           'redirectUrl'          => $order->getRedirectUrl(),
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
            \Zota\Zota::getEndpoint(),
            $data['merchantOrderID'],
            $data['orderAmount'],
            $data['customerEmail'],
            $data['customerBankAccountNumber'],
            \Zota\Zota::getMerchantSecretKey(),
        ];

        $stringToSign = implode($dataToSign);

        $data['signature'] = hash('sha256', $stringToSign);

        return $data;
    }
}
