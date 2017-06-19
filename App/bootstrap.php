<?php

$core = \App\Libs\Core::getInstance();
$app = $core->getSlimInstance();

$authLogin = new SlimPower\Authentication\Callables\DemoAuthenticator($app);
$authToken = new \SlimPower\Authentication\Callables\TokenNullAuthenticator($app);
$error = new App\Security\CustomError($app);
$security = \App\Security\SecManager::getInstance($app, $authLogin, $authToken, $error);
$security->addTokenRelaxed(unserialize(TOKEN_RELAXED));
$security->addInsecurePaths(unserialize(INSECURE_PATH));
$security->setWarningPaths(unserialize(WARNING_PATH));
$security->setTokenSecret(TOKEN_SECRET);
$security->setTokenValidity(TOKEN_VALIDITY);
$security->start();
