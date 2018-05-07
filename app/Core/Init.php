<?php
namespace App\Core;

use Base;
use \Symfony\Component\Yaml\Parser;
use App\Core\Router;
use App\Core\F3\BaseModel;

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
        $this->initAssets();
    }

    private function initAssets()
    {
        $app = $this->app;
        $this->app->route(
            'GET /assets/@type',
            function ($app, $args) {
                $path = $this->app->get('config.dir.assets') . $args['type'] . '/';
                $files = preg_replace('/(\.+\/)/', '', $_GET['files']); // close potential hacking attempts  
                echo \Web::instance()->minify($files, null, true, $path);
            }
        );

    }
    
    private function parseConfig(array $config)
    {
        foreach ($config as $key => $value) {
            $this->config[$key] = $value;
        }

        if (isset($this->config['debug'])) {
            $this->app->set('DEBUG', $this->config['debug']);
        }

        unset($this->config['debug']);

        $this->app->set('config', $this->config);
    }
    
    private function parseRouter()
    {
        $modules = $this->config['modules'];
        // var_dump($this->config['dir']['module']);die();
        foreach ($modules as $module => $option) {
            if ($option['enabled']) {
                $route = dirname(__DIR__).'/'.$this->config['dir']['module'].'/'.ucfirst($module).'/router.yaml';
                if (file_exists($route)) {
                    $routes = $this->parser->parseFile($route);
                    foreach ($routes as $name => $opt) {
                        if (isset($opt['middleware'])) {
                            $this->app->set('middleware', array("{$module}.{$name}" => $opt['middleware']));
                        }
                        $this->app->route("{$opt['method']} @{$module}.{$name}: {$opt['url']}", ucfirst($this->config['dir']['module']) . '\\' . ucfirst($module) . '\\' . $opt['target']);
                    }
                }
            }
        }
    }

    public function run()
    {
        \Middleware::instance()->run();
        $this->app->run();
    }
}