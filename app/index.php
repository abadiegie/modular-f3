<?php
/**
 * First, autoload
 * Then the whole world
 */
require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 *
 * This file will load config file and run
 *
 */
$config = __DIR__.'/config.yaml';
$init = new App\Core\Init($config);
$init->run();
