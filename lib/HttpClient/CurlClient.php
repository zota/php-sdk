<?php

namespace Zota\HttpClient;

use Zota\Helper\Helper;
use Zota\Exception\ApiConnectException;
use Zota\Exception\HttpClientException;
use Zota\Exception\InvalidArgumentException;
use Zota\Zota;

/**
 * Class CurlClient.
 */
class CurlClient implements HttpClientInterface
{
    /**
     * The cURL handle for the session
     * @var resource
     */
    protected $curlHandle;
    protected $curlVersion;

    protected const CURL_MIN_VERSION = '7.34.0';
    protected const DEFAULT_SSLVERSION = 6; // CURL_SSLVERSION_TLSv1_2
    protected const DEFAULT_CONNECT_TIMEOUT = 30;
    protected const DEFAULT_TIMEOUT = 90;


    /**
     * Check cURL availability and minimum required version.
     *
     * @throws \Zota\Exception\HttpClientException
     */
    public function __construct()
    {
        if (!function_exists("curl_version")) {
            // @codeCoverageIgnoreStart
            throw new HttpClientException('cURL module is not available on this system');
            // @codeCoverageIgnoreEnd
        }

        $curl_version = curl_version();
        $this->curlVersion = $curl_version['version'];

        if (version_compare($this->curlVersion, self::CURL_MIN_VERSION, '<')) {
            // @codeCoverageIgnoreStart
            throw new HttpClientException('cURL minimum required version ' . self::CURL_MIN_VERSION);
            // @codeCoverageIgnoreEnd
        }
    }


    /**
     * Close cURL session.
     */
    public function __destruct()
    {
        $this->closeCurlHandle();
    }


    /**
     * Make a HTTP request.
     *
     * @codeCoverageIgnore

     * @param string $method method used for the request
     * @param string $url full representation of the requested url
     * @param array $params the data passed to the request
     *
     * @throws \Zota\Exception\InvalidArgumentException
     *
     * @return array|false
     */
    public function request($method, $url, $params)
    {
        // reset handle
        $this->resetCurlHandle();

        // set options
        $opts = [];

        // prepare logging to hide sensitive data
        $url_log = $url;

        $method = \strtolower($method);
        if ('get' === $method) {
            $opts[\CURLOPT_HTTPGET] = 1;

            // logging data
            $opts_log['CURLOPT_HTTPGET'] = $opts[\CURLOPT_HTTPGET];

            if (!empty($params)) {
                // logging marker
                $url_log = $url . '?***';

                $queryString = Helper::parametersToQueryString($params);
                $url = $url . '?' . $queryString;
            }
        } elseif ('post' === $method) {
            $opts[\CURLOPT_POST] = 1;
            $opts[\CURLOPT_HTTPHEADER] = array( 'Content-Type:application/json' );
            $opts[\CURLOPT_POSTFIELDS] = \json_encode($params);

            // logging data
            $params_log = array();
            foreach ($params as $key => $value) {
                if ('merchantOrderID' === $key) {
                    $params_log[$key] = $value;
                    continue;
                }
                $params_log[$key] = '***';
            }
            $opts_log['CURLOPT_POST'] = $opts[\CURLOPT_POST];
            $opts_log['CURLOPT_HTTPHEADER'] = $opts[\CURLOPT_HTTPHEADER];
            $opts_log['CURLOPT_POSTFIELDS'] = \json_encode($params_log);
        } else {
            throw new InvalidArgumentException('Unrecognized method ' . $method);
        }

        // logging debug
        Zota::getLogger()->debug('CurlClient request method: {method}', ['method' => $method]);

        $opts[\CURLOPT_URL] = $url;
        $opts[\CURLOPT_RETURNTRANSFER] = true;
        $opts[\CURLOPT_CONNECTTIMEOUT] = self::DEFAULT_CONNECT_TIMEOUT;
        $opts[\CURLOPT_TIMEOUT] = self::DEFAULT_TIMEOUT;
        $opts[\CURLOPT_SSLVERSION] = self::DEFAULT_SSLVERSION;
        $opts[\CURLOPT_USERAGENT] = sprintf(
            self::USERAGENT,
            Zota::VERSION,
            \implode(
                '; ',
                [
                    php_uname('s') . ' ' . php_uname('r'),
                    'PHP ' . phpversion(),
                    'cURL ' . $this->curlVersion,
                ]
            )
        );

        // logging data and hide sensitive data
        $opts_log['CURLOPT_URL'] = preg_replace('/\/request\/(.*)/', '/request/***', $url_log);
        $opts_log['CURLOPT_RETURNTRANSFER'] = $opts[\CURLOPT_RETURNTRANSFER] ? 'true' : 'false';
        $opts_log['CURLOPT_CONNECTTIMEOUT'] = $opts[\CURLOPT_CONNECTTIMEOUT];
        $opts_log['CURLOPT_SSLVERSION'] = $opts[\CURLOPT_SSLVERSION];
        $opts_log['CURLOPT_USERAGENT'] = 'Zota PHP SDK ***';

        // logging debug
        Zota::getLogger()->debug('CurlClient request set opts: {opts}', ['opts' => print_r($opts_log, true)]);

        \curl_setopt_array($this->curlHandle, $opts);

        // execute request
        Zota::getLogger()->debug('CurlClient execute request.');
        $request = \curl_exec($this->curlHandle);

        if (false === $request) {
            $errno = \curl_errno($this->curlHandle);
            $error = \curl_error($this->curlHandle);
            Zota::getLogger()->error(
                'CurlClient request error [{errno}]: {error} at {url}',
                [
                    'errno' => $errno,
                    'error' => $error,
                    'url'   => $url,
                ]
            );
        } else {
            $code = \curl_getinfo($this->curlHandle, \CURLINFO_HTTP_CODE);
            Zota::getLogger()->debug('CurlClient request HTTP_CODE {code}', ['code' => $code]);
        }

        // close handle
        Zota::getLogger()->debug('CurlClient close handle.');
        $this->closeCurlHandle();

        // handle error
        if (false === $request) {
            $this->handleCurlError($url, $errno, $error);
            return false;
        }

        return [ $request, $code ];
    }


    /**
     * Handle request errors.
     *
     * @param string $url
     * @param int $errno
     * @param string $error
     *
     * @throws \Zota\Exception\ApiConnectException
     */
    private function handleCurlError($url, $errno, $error)
    {
        $message = '';

        switch ($errno) {
            // @codeCoverageIgnoreStart
            case \CURLE_COULDNT_CONNECT:
                $message .= 'Could not connect to Zota. ';
                break;
            case \CURLE_COULDNT_RESOLVE_HOST:
                $message .= 'Could not resolve host. ';
                break;
            case \CURLE_OPERATION_TIMEOUTED:
                $message .= 'Operation timed out. ';
                break;
            case \CURLE_SSL_CACERT:
                $message .= 'The remote server\'s SSL certificate not OK. ';
                break;
            default:
                $message .= 'Unknown error. ';
            // @codeCoverageIgnoreEnd
        }

        $message  .= PHP_EOL . 'Network error [' . $errno . ']: ' . $error . ' at ' . $url . PHP_EOL;

        throw new ApiConnectException($message);
    }


    /**
     * Initializes the curl handle. If already initialized, the handle is closed first.
     *
     * @throws \Zota\Exception\ApiConnectException
     */
    private function initCurlHandle()
    {
        $this->closeCurlHandle();
        $this->curlHandle = \curl_init();

        if (false === $this->curlHandle) {
            // @codeCoverageIgnoreStart
            throw new ApiConnectException('Could not init cURL');
            // @codeCoverageIgnoreEnd
        }
    }


    /**
     * Closes the curl handle if initialized. Do nothing if already closed.
     */
    private function closeCurlHandle()
    {
        if (null !== $this->curlHandle) {
            \curl_close($this->curlHandle);
            $this->curlHandle = null;
        }
    }


    /**
     * Resets the curl handle. If the handle is not already initialized, the handle is reinitialized instead.
     */
    private function resetCurlHandle()
    {
        if (null !== $this->curlHandle) {
            \curl_reset($this->curlHandle);
        } else {
            $this->initCurlHandle();
        }
    }
}
