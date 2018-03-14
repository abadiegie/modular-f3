<?php
namespace App\Core;

use Base;
use \Symfony\Component\Yaml\Parser;
use App\Core\Router;

/**
 * Init Framework
 */
class Init
{
    /**
     * Init Framework
     */

    protected $app;
    protected $config;
    protected $parser;

    /**
     * var $config : config file location 
     */
    public function __construct($config)
    {
        $this->parser = new Parser();
        $config = $this->parser->parseFile($config);
        $this->app = Base::instance();
        $this->parseConfig($config);
        $this->parseRouter();
    }
    
    private function parseConfig(array $config)
    {
        foreach ($config as $key => $value) {
            $this->app->set($key, $value);
        }
    }
    
    private function getActiveModule()
    {
        $modules = $this->app->get('modules');
        $active = array();
        foreach ($modules as $name => $option) {
            if ($option['enable']) {
                $active[] = $name;
            }
        }
        return $active;
    }
    
    private function parseRouter()
    {
        $activeModules = $this->getActiveModule();
        $router = $this->parser->parseFile(dirname(__DIR__).'/'.$this->app->get('dir.router').'.yaml');
        $routes = array();
        foreach ($router as $module => $route) {
            if (in_array($module, $activeModules)) {
                foreach ($route as $name => $opt) {
                    $this->app->route("{$opt['method']} @{$module}_{$name}: {$opt['url'] }", "{$opt['target']}");
                }
            }
        }
    }

    public function run()
    {
        // echo "<pre>",var_dump($this->app->get('ROUTES')),"</pre>";die();
        $this->app->run();
    }
}