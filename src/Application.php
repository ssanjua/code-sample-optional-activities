<?php

namespace Bdt\Example;

class Application
{
    /**
     * @var array
     */
    public $server;
    /**
     * @var array
     */
    public $post;
    /**
     * @var array
     */
    public $get;

    /**
     * @var array
     */
    protected $routes;

    /**
     * Application constructor.
     * @param $server
     * @param $post
     * @param $get
     */
    public function __construct($server, $post, $get)
    {
        $this->server = $server;
        $this->post   = $post;
        $this->get    = $get;
    }

    /**
     * @param $path
     * @param $controller
     * @return $this
     */
    public function route($path, $controller)
    {
        $this->routes[$path] = $controller;    
        return $this;
    }

    public function run()
    {
        $uri = strtok($_SERVER["REQUEST_URI"], '?');
        foreach ($this->routes as $route => $call) {
            if ($uri == $route) {
                $parts = explode('::', $call);
                $controllerClass = $parts[0];
                $controllerAction = $parts[1];

                $class = new $controllerClass($this);
                echo $class->$controllerAction();
                return;
            }
        }
    }
}