<?php
use Squids\SquidsScope;
use Squids\Base\Module\ICLIController;

spl_autoload_register(function($class)
{
    include 'phar://' . basename(__DIR__) . '/' . str_replace('\\', '/', $class) . '.php';
});

/** @var ICLIController $controller */
$controller = SquidsScope::skeleton(ICLIController::class);
$controller->run();