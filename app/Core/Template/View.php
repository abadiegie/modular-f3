<?php
namespace App\Core\Template;

use Twig;
use App\Core\Template\Init;
/**
 * 
 */
trait View
{
    use \App\Core\F3\F3;

    public function render($template, array $var = [])
    {
        $alias = $this->base()->get('ALIAS');
        $module = explode('.', $alias);
        $dir = dirname(dirname(__DIR__)) . '/' . $this->base()->get('config.dir.module').'/'.ucfirst($module[0] . '/view');
        $loader = new \Twig_Loader_Filesystem($dir);
        $cache = dirname(dirname(__DIR__)).'/'.$this->base()->get('config.dir.tmp') . '/cache/' . $module[0];
        
        if (!is_dir($cache)) {
            mkdir($cache, 0777);
        }
        
        $twig = new \Twig_Environment($loader, array(
            'cache' => false,
            // 'auto_reload' => true
        ));

        $var['app'] = $this->base()->get('config.app');
        $var['base'] = $this->base()->get('BASE');

        try {
            echo $twig->render($template, $var);
        } catch (\Exception $e) {
            return $e;
        }
    }
}
