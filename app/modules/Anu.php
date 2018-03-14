<?php
namespace Modules;

class Anu extends Controller
{
    public function index()
    {
        $routes = $this->base()->get('ROUTES');
        echo '<pre>', var_dump($routes), '</pre>';
    }

    public function test()
    {
        echo "test";
    }
}
