<?php

namespace Zota;

/**
 * @internal
 */
final class OrdersReportApiResponseTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Data Array
     * @return array
     */
    public static function getData()
    {
        return [
            [
                // httpClientRequest
                [
                    'raw csv goes here',
                    200
                ],

                // ref
                [
                    'data' => 'raw csv goes here',
                    'message' => null,
                    'code' => 200,
                ],
            ],
            [
                // httpClientRequest
                [
                    '{"code":"400","message":"Error.","data":{}}',
                    400
                ],

                // ref
                [
                    'data' => null,
                    'message' => 'Error.',
                    'code' => 400,
                ],
            ],
            [
                // httpClientRequest
                false,

                // ref
                [
                    'data' => null,
                    'message' => 'Zota API Response not valid.',
                    'code' => null,
                ],
            ],
        ];
    }


    /**
     * ApiResponse getters
     *
     * @dataProvider getData
     */
    public function testGetters($httpClientRequest, $ref)
    {
        $apiResponse = new \Zota\OrdersReportApiResponse($httpClientRequest);

        static::assertSame($ref['data'], $apiResponse->getData());
        static::assertSame($ref['message'], $apiResponse->getMessage());
        static::assertSame($ref['code'], $apiResponse->getCode());
    }
}
