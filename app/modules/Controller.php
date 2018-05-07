<?php
namespace Modules;

use App\Core\Template\View;

class Controller
{
    use View;

    public function beforeRoute()
    {
        $middleware = $this->base()->get('middleware');
        $alias = $this->base()->get('ALIAS');
        if ($middleware[$alias]) {
            $this->base()->call("{$middleware[$alias]}->handle");
        }
    }
}
