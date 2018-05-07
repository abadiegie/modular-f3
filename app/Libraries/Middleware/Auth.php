<?php
namespace App\Libraries\Middleware;

class Auth
{
    use \App\Core\F3\F3;

    public function handle()
    {
        return $this->base()->reroute('http://google.com');
    }
}
