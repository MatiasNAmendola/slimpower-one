<?php

namespace App\Security;

use SlimPower\AuthenticationManager\AuthManager;
use SlimPower\AuthenticationManager\Interfaces\ManagerInterface;
use SlimPower\Authentication\Abstracts\LoginAuthMiddleware;
use SlimPower\Authentication\Abstracts\TokenAuthMiddleware;

class SecManager extends AuthManager implements ManagerInterface {

    private function getParams() {
        $app = $this->app;

        $auth = array(
            LoginAuthMiddleware::KEY_USERNAME => $app->request->params(LoginAuthMiddleware::KEY_USERNAME),
            LoginAuthMiddleware::KEY_PASSWORD => $app->request->params(LoginAuthMiddleware::KEY_PASSWORD)
        );

        return $auth;
    }

    private function getHeader() {
        $auth = array(LoginAuthMiddleware::KEY_USERNAME => '', LoginAuthMiddleware::KEY_PASSWORD => '');

        $app = $this->app;

        $headers = $app->request->headers;

        if ($headers->get(LoginAuthMiddleware::KEY_USERNAME) && $headers->get(LoginAuthMiddleware::KEY_PASSWORD)) {
            $auth[LoginAuthMiddleware::KEY_USERNAME] = $headers->get(LoginAuthMiddleware::KEY_USERNAME);
            $auth[LoginAuthMiddleware::KEY_PASSWORD] = $headers->get(LoginAuthMiddleware::KEY_PASSWORD);
        }

        return $auth;
    }

    /**
     * Get login data
     * @return array Login data
     */
    protected function login() {
        if (!AUTH_IN_HEADER) {
            $auth = $this->getParams();
        } else {
            $auth = $this->getHeader();
        }

        return $auth;
    }

    protected function sendCredential($token) {
        $app = $this->app;

        $app->render(200, array(
            TokenAuthMiddleware::KEY_TOKEN => $token,
        ));
    }

}
