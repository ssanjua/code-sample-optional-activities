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
     * Register a new route.
     * 
     * @param $path
     * @param $controller
     * @return $this
     */

    public function route($path, $controller)
    {
        $this->routes[$path] = $controller;
        return $this;
    }

    /**
     * Run the application and handle incoming requests.
     * 
     * The modifications added to the run() method allow the 
     * application to handle more complex routes with parameters
     * introducing support for routing with route parameters using regex.
     * The modified system can handle routes like /post/{id:\d+},
     * where {id:\d+} acts as a placeholder for a post's ID
     * 
     */
    public function run()
    {
        $uri = strtok($_SERVER["REQUEST_URI"], '?');
        foreach ($this->routes as $route => $call) {
            $route = str_replace('/', '\/', $route);  // Escape slashes for regex pattern.
            
            // Convert route parameters to a regex pattern.
            // For example, /post/{id:\d+} will capture digit-only ids.
            $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<$1>$2)', $route);  
            
            // Check if the route pattern matches the current URI.
            if (preg_match('/^' . $route . '$/', $uri, $matches)) {
                $parts = explode('::', $call);
                $controllerClass = $parts[0];
                $controllerAction = $parts[1];
                
                $class = new $controllerClass($this);
                
                // Check if the "id" key exists in matched parts.
                // This is useful for routes that capture an id, e.g. /post/{id:\d+}.
                if(isset($matches['id'])) {
                    echo $class->$controllerAction($matches['id']);  // Pass the captured id.
                } else {
                    echo $class->$controllerAction();
                }
                return;
            }
        }
    }

}