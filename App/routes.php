<?php

$config = new \SlimPower\Config\Config("config.json");

$routes = $config->get('routes');

// Set up routes

$app->get('/', 'App\Controller\Home:index');

foreach ($routes as $route) {
    $app->addRoute($route);
}

$app->notFound(function () use ($app) {
    $app->render(404, array(
        'error' => TRUE,
        'msg' => 'not found',
    ));
});
