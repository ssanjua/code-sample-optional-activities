<?php

namespace Bdt\Example;

use Bdt\Example\Application;

class Controller
{
    protected $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }
}