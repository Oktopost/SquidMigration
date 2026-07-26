<?php
use Squids\SquidsScope;
use Squids\Base\Module\ICLIController;


spl_autoload_register(function($class)
{
	static $psr4Prefixes = [
		'Squids\\',
	];
	
	foreach ($psr4Prefixes as $prefix)
	{
		if (substr($class, 0, strlen($prefix)) == $prefix)
		{
			$class = substr($class, strlen($prefix));
			break;
		}
	}
	
    include 'phar://' . basename(__DIR__) . '/' . str_replace('\\', '/', $class) . '.php';
});

require 'phar://' . basename(__DIR__) . '/skeleton.php';


/** @var ICLIController $controller */
$controller = SquidsScope::skeleton(ICLIController::class);
exit($controller->run());
