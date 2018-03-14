<?php
namespace Modules;

class Tas extends Controller
{
    public function index()
    {
        $routes = $this->base()->get('ROUTES');
        echo '<pre>', var_dump($routes), '</pre>';
    }
}
