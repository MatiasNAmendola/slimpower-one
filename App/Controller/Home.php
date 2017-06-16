<?php

namespace App\Controller;

class Home {

    // Optional properties
    protected $app;
    protected $request;
    protected $response;

    public function error() {
        throw new \Exception("There was something wrong with your request!");
    }

    public function index() {
        $this->app->render(200, array(
            'msg' => 'Welcome to the API!',
        ));
    }

    public function hi($name = 'guest') {
        $this->app->render(200, array(
            'msg' => "Hi, {$name}",
        ));
    }

    // Optional setters
    public function setApp($app) {
        $this->app = $app;
    }

    public function setRequest($request) {
        $this->request = $request;
    }

    public function setResponse($response) {
        $this->response = $response;
    }

    // Init
    public function init() {
        // Do things now that app, request and response are set.
    }

}
