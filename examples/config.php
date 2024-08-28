<?php

// phpcs:disable 
require 'autoload.php';

// Error reporting
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

// Endpoints URL
define('Zota_EXAMPLES_URL', 'http://Zota.local/php-sdk/examples');
// phpcs:enable

// Settings
\Zota\Zota::setMerchantId(getenv('API_MERCHANT_ID'));
\Zota\Zota::setMerchantSecretKey(getenv('API_MERCHANT_SECRET_KEY'));
\Zota\Zota::setEndpoint('503364');  // USD Sandbox environment
\Zota\Zota::setApiBase('https://api.Zota-sandbox.com'); // Sandbox environment

// Logging
\Zota\Zota::setLogThreshold('debug');
\Zota\Zota::setLogDestination(dirname(__FILE__) . '/test.log');
