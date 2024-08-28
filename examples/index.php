<?php

use Zota\Zota;
use Zota\Deposit;
use Zota\DepositOrder;

// error reporting
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

require 'autoload.php';

/**
 * Settings ----------------------------------------
 */
Zota::setMerchantId(getenv('API_MERCHANT_ID'));
Zota::setMerchantSecretKey(getenv('API_MERCHANT_SECRET_KEY'));
Zota::setEndpoint('503364');  // USD Sandbox environment
Zota::setApiBase('https://api.Zota-sandbox.com'); // Sandbox environment
