<?php

$logWriter = new \Slim\LogWriter(fopen(LOG_FILE, 'a'));

$app = new \SlimPower\Slim\Slim(array('mode' => APP_ENV,
    'debug' => (APP_ENV == 'development'),
    'log.enabled' => (APP_ENV == 'development'),
    'log.level' => \Slim\Log::DEBUG,
    //'log.level' => \Slim\Log::INFO,
    'log.writer' => $logWriter));

$authLogin = new SlimPower\Authentication\Callables\DemoAuthenticator($app);
$authToken = new \SlimPower\Authentication\Callables\NullAuthenticator($app);
$error = new App\Security\CustomError($app);
$security = \App\Security\SecManager::getInstance($app, $authLogin, $authToken, $error);
$security->addTokenRelaxed(unserialize(TOKEN_RELAXED));
$security->addInsecurePaths(unserialize(INSECURE_PATH));
$security->setWarningPaths(unserialize(WARNING_PATH));
$security->setTokenSecret(TOKEN_SECRET);
$security->setTokenValidity(TOKEN_VALIDITY);
$security->start();

$app->hook('slim.after', function () use ($app) {
    $request = $app->request;
    $response = $app->response;

    $app->log->debug('');
    $app->log->debug('------------- ' . date('Y-m-d H:i:s') . ' -------------');
    $app->log->debug('Request path: ' . $request->getPathInfo());
    $app->log->debug('Response status: ' . $response->getStatus());
    $app->log->debug('Method: ' . $request->getMethod());
    $app->log->debug('IP: ' . $request->getIp());
});

$app->add(new \SlimPower\Slim\Middleware\Json\Middleware($app, array(
    'json.status' => true,
    'json.override_error' => true,
    'json.override_notfound' => true,
    'json.debug' => (APP_ENV == 'development')
)));

