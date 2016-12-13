<?php

namespace App\Controller;

class Home {

    // Optional properties
    protected $app;
    protected $request;
    protected $response;

    public function error() {
        throw new \Exception("Something wrong with your request!");
    }

    public function index() {
        $this->app->render(200, array(
            'msg' => 'welcome to my API!',
        ));
    }

    public function hello($name = 'test') {
        $this->app->render(200, array(
            'msg' => "Hello, $name",
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
        // do things now that app, request and response are set.
    }

}
