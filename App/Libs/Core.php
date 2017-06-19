<?php

namespace App\Libs;

class Core {

    /**
     * Save instance
     * @var \App\Libs\Core
     */
    private static $instance;

    /**
     * Instance name
     * @var string
     */
    private $name = 'default';

    /**
     * Gets instance
     * @return \App\Libs\Core
     */
    public static function getInstance() {

        if (!isset(self::$instance)) {
            $object = __CLASS__;
            self::$instance = new $object;
        }

        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct() {
        
    }

    /**
     * Sets instance name
     * @param string $name Instance name
     */
    public function setName($name = 'default') {
        $this->name = $name;
    }

    /**
     * Gets instance name
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Get Slimpower instance
     * @return \SlimPower\Slim\Slim
     */
    public function getSlimInstance() {
        $app = \SlimPower\Slim\Slim::getInstance($this->name);

        if (is_null($app)) {
            return $this->getApp();
        }

        return $app;
    }

    /**
     * Configure logger
     * @param \SlimPower\Slim\Slim $app Slimpower instance
     */
    private function configureLogger(\SlimPower\Slim\Slim $app) {
        $app->hook('slim.after', function () use ($app) {
            $request = $app->request;
            $response = $app->response;

            $app->log->debug('');
            $app->log->debug('------------- ' . date('Y-m-d H:i:s') . ' -------------');
            $app->log->debug('Request path: ' . $request->getPathInfo());
            $app->log->debug('Response status: ' . $response->getStatus());
            $app->log->debug('Method: ' . $request->getMethod());
            $app->log->debug('IP: ' . $request->getIp());

            if (preg_match('/application\/json/', $response->header('Content-Type'))) {
                $app->log->debug('DATA: ' . $response->getBody());
            }
        });
    }

    /**
     * Get LogWriter instance
     * @param string $logFile Log file.
     * @return \Slim\LogWriter LogWriter instance
     */
    private function getLogWriterInstance($logFile) {
        $logDir = dirname($logFile);

        if (!file_exists($logDir)) {
            $oldmask = umask(0);
            mkdir($logDir, 0777, TRUE);
            umask($oldmask);
        }

        $logWriter = new \Slim\LogWriter(fopen($logFile, 'a+'));
        return $logWriter;
    }

    /**
     * Gets new Slimpower instance
     * @return \SlimPower\Slim\Slim
     */
    private function getApp() {
        $logWriter = $this->getLogWriterInstance(LOG_FILE);

        $app = new \SlimPower\Slim\Slim(array(
            'mode' => APP_ENV,
            'log.level' => LOG_LEVEL,
            'log.writer' => $logWriter));

        $app->setName($this->name);

        $this->configureLogger($app);

        return $app;
    }

}
