<?php

namespace App\Security;

use SlimPower\AuthenticationManager\AuthManager;
use SlimPower\AuthenticationManager\Interfaces\ManagerInterface;

class SecManager extends AuthManager implements ManagerInterface {

    private function getParams() {
        $app = $this->app;

        $auth = array(
            'user' => $app->request->params('user'),
            'password' => $app->request->params('password')
        );

        return $auth;
    }

    private function getHeader() {
        $auth = array('user' => '', 'password' => '');

        $app = $this->app;
        
        $headers = $app->request->headers;

        if ($headers->get("user") && $headers->get("password")) {
            $auth['user'] = $headers->get("user");
            $auth['password'] = $headers->get("password");
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
            'token' => $token,
        ));
    }

}
