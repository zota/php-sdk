<?php

namespace Zota;

/**
 * @internal
 */
final class PayoutOrderTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Data Array
     * @return array
     */
    public static function getData()
    {
        $order = [
            'merchantOrderID'   => '1',
            'merchantOrderDesc' => 'Payout order test description',
            'orderAmount'       => '100.00',
            'orderCurrency'     => 'USD',
            'customerEmail'     => 'testing@Zota-api.com',
            'customerFirstName' => 'John',
            'customerLastName'  => 'Lock',
            'customerPhone'     => '+1 420-100-1000',
            'customerIP'        => '134.201.250.130',
            'customerBankCode'  => 'BBL',
            'customerBankAccountNumber' => '1234567890', // other will be DECLINED, 0000000000 for ERROR
            'customerBankAccountName' => 'John Doe',
            'customerBankBranch' =>  'Bank Branch',
            'customerBankAddress' => 'Thong Nai Pan Noi Beach, Baan Tai, Koh Phangan',
            'customerBankZipCode' => '84280',
            'customerBankRoutingNumber' => '000',
            'customerBankProvince' => 'Bank Province',
            'customerBankArea'  => 'Bank Area / City',
            'callbackUrl'       => 'http:://localhost/callback',
            'customParam'       => json_encode([ 'TestCustomParam' => '123' ]),
            'language'          => 'EN',
            'customerCountryCode' => 'TH',
            'customerPersonalID' => '12345678',
            'customerBankAccountNumberDigit' => '02',
            'customerBankAccountType'  => '03',
            'customerBankSwiftCode'       => '123456789',
            'customerBankBranchDigit'       => '04',
            'redirectUrl'          => 'https://testingZotaredirecturl.com',

        ];

        return [
            [
                $order
            ],
        ];
    }


    /**
     * Gets Object Instance with Data in Constructor
     *
     * @dataProvider getData
     */
    public function testPayoutOrderWithData($data)
    {
        $ZotaPayoutOrder = new \Zota\PayoutOrder($data);

        $this->assertInstanceOf(\Zota\PayoutOrder::class, $ZotaPayoutOrder);
    }


    /**
     * Test getters
     *
     * @dataProvider getData
     */
    public function testGetters($data)
    {
        $ZotaDepositOrder = new \Zota\PayoutOrder($data);

        foreach ($data as $key => $value) {
            $getter = 'get' . \ucwords($key);

            $this->assertEquals($ZotaDepositOrder->$getter(), $value);
        }
    }
}
