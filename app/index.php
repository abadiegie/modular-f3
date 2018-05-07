<?php
/**
 * First, autoload
 * Then the whole world
 */
require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 *
 * put config file
 *
 */
$config = __DIR__.'/etc/config.yaml';
$init = new App\Core\Init($config);
$init->run();
