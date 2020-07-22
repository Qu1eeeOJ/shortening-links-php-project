<?php

namespace App\Vendor\Application;

class Application implements ApplicationInterface
{
    // Date about the app
    protected $app;

    /**
     * Application constructor.
     *
     * @param $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * To obtain data on the app
     *
     * @return mixed
     */
    public function getApp()
    {
        return $this->app;
    }

}