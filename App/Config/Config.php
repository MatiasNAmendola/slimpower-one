<?php

use SlimPower\Slim\Libs\Net;

$config = new \SlimPower\Config\Config("config.json");

/**
 * Configuration
 *
 * For more info about constants please @see http://php.net/manual/es/function.define.php
 * If you want to know why we use "define" instead of "const" @see http://stackoverflow.com/q/2447791/1114320
 */
/**
 * Configuration for: Basics
 */
define('DS', DIRECTORY_SEPARATOR);

/**
 * Configuration for: Environment
 */
define('APP_NAME', $config->get("appname"));
define('APP_ENV', $config->get("environment", \SlimPower\Slim\Slim::MODE_DEV));
define('APP_SECURE', Net::isSecure());
define('APP_PATH', $config->get("apppath"));
define('APP_DIR', dirname(dirname(__DIR__)) . DS);

/**
 * Configuration for: Project URL
 */
define('LOCALHOST', Net::getLocalHost());
define('LOCAL_IP', Net::getLocalIP());
define('URL', Net::getBasicPath() . APP_PATH);

/**
 * Configuration for: JWT & Security
 */
$token = $config->get("token");

define('AUTH_IN_HEADER', $config->get("authinheader", true));

define('TOKEN_SECRET', $token["secret"]);
define('TOKEN_VALIDITY', $token["validity"]);

define("TOKEN_RELAXED", serialize(array(LOCALHOST, LOCAL_IP)));
define("INSECURE_PATH", serialize($token["insecurepaths"]));
define("WARNING_PATH", serialize($token["warningpaths"]));

/**
 * Configuration for: Error reporting
 * For more info about errors please @see http://php.net/manual/es/function.error-reporting.php
 */
ini_set('error_reporting', (APP_ENV != \SlimPower\Slim\Slim::MODE_PROD) ? E_ALL : 0 );

// Error handling
ini_set('display_errors', (APP_ENV != \SlimPower\Slim\Slim::MODE_PROD));

/**
 * Configuration for: Log
 */
define('LOG_FILE', APP_DIR . $config->get('logfile'));

/**
  \Slim\Log::EMERGENCY = 1;
  \Slim\Log::ALERT     = 2;
  \Slim\Log::CRITICAL  = 3;
  \Slim\Log::ERROR     = 4;
  \Slim\Log::WARN      = 5;
  \Slim\Log::NOTICE    = 6;
  \Slim\Log::INFO      = 7;
  \Slim\Log::DEBUG     = 8;
 */
$logLevel = $config->get('loglevel', 'INFO');
define('LOG_LEVEL', \Slim\Log::$logLevel);
