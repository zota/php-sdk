<?php

use Zota\Zota;

// error reporting
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

require 'autoload.php';

/**
 * Logger ----------------------------------------
 */
$logDestination = dirname(__FILE__) . '/test.log';
\Zota\Zota::setLogDestination($logDestination);

$message = 'Test {test}';
$context = [ 'test' => '1' ];

\Zota\Zota::getLogger()->critical($message, $context);
