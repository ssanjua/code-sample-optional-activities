<?php

namespace Bdt\Example;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class View
{
    private $twig;
    private $data;
    private $filename;


    public function __construct($filename)
    {
        $loader = new FilesystemLoader(__DIR__.'/../app/views');
        $this->twig = new Environment($loader, []);
        $this->filename = $filename;
    }

    public function __set($k, $v)
    {
        $this->data[$k] = $v;
    }

    public function render()
    {
        return $this->twig->render($this->filename, $this->data);
    }
}