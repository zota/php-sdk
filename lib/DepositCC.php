<?php

namespace Zota;

/**
 * Class DepositCC.
 */
class DepositCC extends AbstractApiClient
{
    /**
     * Make a deposit request to Zota API with credit card integration.
     *
     * @param \Zota\DepositOrder $order
     *
     * @return \Zota\DepositCCApiResponse
     */
    public function request($order)
    {
        // return directly mock response if available.
        $mockResponse = $this->getMockResponse();
        if (!empty($mockResponse)) {
            Zota::getLogger()->debug('Using mocked response for depositCC request.', []);
            $response = new \Zota\DepositCCApiResponse($mockResponse);
            return $response;
        }

        // setup url
        $url =  \Zota\Zota::getApiUrl() .
                '/deposit/request/' .
                \Zota\Zota::getEndpoint();

        // setup data
        Zota::getLogger()->debug('merchantOrderID #{merchantOrderID} Deposit CC prepare post data.', ['merchantOrderID' => $order->getMerchantOrderID()]);
        $data = $this->prepare($order);
        $signed = $this->sign($data);

        // make the request
        Zota::getLogger()->info('Deposit CC request.');
        $request = $this->apiRequest->request('post', $url, $signed);

        // set the response
        Zota::getLogger()->debug('merchantOrderID #{merchantOrderID} Deposit CC response.', ['merchantOrderID' => $order->getMerchantOrderID()]);
        $response = new \Zota\DepositCCApiResponse($request);

        return $response;
    }


    /**
     * @param \Zota\DepositOrder $order
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
            'customerAddress'   => $order->getCustomerAddress(),
            'customerCountryCode' => $order->getCustomerCountryCode(),
            'customerCity'      => $order->getCustomerCity(),
            'customerState'     => $order->getCustomerState(),
            'customerZipCode'   => $order->getCustomerZipCode(),
            'customerPhone'     => $order->getCustomerPhone(),
            'customerIP'        => $order->getCustomerIP(),
            'customerBankCode'  => $order->getCustomerBankCode(),
            'customerBankAccountNumber' => $order->getCustomerBankAccountNumber(),
            'redirectUrl'       => $order->getRedirectUrl(),
            'callbackUrl'       => $order->getCallbackUrl(),
            'checkoutUrl'       => $order->getCheckoutUrl(),
            'customParam'       => $order->getCustomParam(),
            'language'          => $order->getLanguage(),
            'cardHolderName'    => $order->getCardHolderName(),
            'cardNumber'        => $order->getCardNumber(),
            'cardExpirationMonth' => $order->getCardExpirationMonth(),
            'cardExpirationYear' => $order->getCardExpirationYear(),
            'cardCvv'           => $order->getCardCvv(),
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
            \Zota\Zota::getMerchantSecretKey(),
        ];

        $stringToSign = implode($dataToSign);

        $data['signature'] = hash('sha256', $stringToSign);

        return $data;
    }
}
