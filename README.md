[![codecov](https://codecov.io/gh/zota/php-sdk/branch/master/graph/badge.svg?token=6M6BPB0HYP)](https://codecov.io/gh/zota/php-sdk)
[![PHP Quicktest](https://github.com/zota/php-sdk/actions/workflows/php-quicktest.yml/badge.svg)](https://github.com/zota/php-sdk/actions/workflows/php-quicktest.yml)
[![SDK CI Matrix Build](https://github.com/zota/php-sdk/actions/workflows/ci-matrix.yml/badge.svg)](https://github.com/zota/php-sdk/actions/workflows/ci-matrix.yml)
[![PHP PSR Enforcer](https://github.com/zota/php-sdk/actions/workflows/phpcs.yml/badge.svg)](https://github.com/zota/php-sdk/actions/workflows/phpcs.yml)

![php-sdk](https://github.com/user-attachments/assets/10eb7dd9-778c-4419-8322-8180d67373f7)



# Official Zota PHP SDK

This is the official page of the [Zota](https://www.zota.com) PHP SDK. It is intended to be used by developers who run modern PHP applications and would like to integrate our next-generation payments platform.

## Introduction
PHP SDK provides all the neccessary methods for integrating the Zota Merchant API. This SDK is used by clients, as well as all the related eCommerce plugins for mainstream PHP applications.

## Requirements
- A functioning Zota Sandbox or Production account and related credentials
- PHP version 7.2.0 or greater
- Client URL Library (cURL) version 7.34.0 or greater
- JSON extension enabled

## Usage

### Main configuration
After all the files are loaded configuration is needed. This can be done with the static methods provided in Zota class. Configuration includes:
- Credentials
- API url - test or production environment
- Endpoint
- Logging threshold and location

### API requests
After everything is setup all requests to the API are made with the corresponding classes:
* Deposit
* DepositCC (deposit with Credit card data)
* Payout
* OrderStatus
* OrdersReport

Every request class consist of public request method with data object parameter. There are also private methods for preparation of the data and the signature.

### Making the request
First the data object has to be created and all the needed data setup with the setters (ex. DepositOrder).

After that the request class (ex. Deposit) is created and the request method is called with the data object as parameter.

### Retrieving the response
Every request method returns response object with available getters. In every response object are included getters providing the code, the message and the data as they are received from the API. Also in every response object are included getters for the body of the response, the HTTP code and the JSON. All other getters are request-specific and are available for easier usage of the response further.

### Callback and Merchant redirect handlers
Classes for callbacks and redirects handling are available with the corresponding getters:
- `ApiCallback`
- `MerchantRedirect`

### Additional resources
In addition DefaultLogger class is available for logging. The DefaultLogger includes eight methods for writing logs to the eight RFC 5424 levels (debug, info, notice, warning, error, critical, alert, emergency).

## Examples
Examples are available in `examples` folder.

Loading and configuration:
- `autoload.php` loads all the needed files as bootstrap.
- `config.php` includes main configuration.
* If needed differnet endpoint can be set for different requests.

Requests:
- `deposit.php` - Deposit request
- `deposit-cc.php` - Deposit request with Credit card details
- `payout.php` - Payout request
- `order-status.php` - Order status request
- `orders-report.php` - Orders report request

Order Handlers:
- `callback.php` - API Callback
- `merchant-redirect.php` - API Merchant redirect

Logging:
- `logger.php` - DefaultLogger usage

## Resources
The Zota API guide can be found on the official API Documentation pages for [deposit](https://doc.zota.com/deposit/1.0/) and [payout](https://doc.zota.com/payout/1.0/) operations.

## Support
This SDK is supported and maintaned by Zota. For sign-up and sales inquiries, please contact sales@zota.com. For Support, please use support@zota.com and include customer identifiable information, along with a description of the issue.
