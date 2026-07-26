<?php

namespace {
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
}

/**
 * Knot connectors call get_param_class() unqualified. Provide a namespaced
 * polyfill so early PHAR DI works without loading global skeleton.php, which
 * the host Composer autoload will declare later when migration actions boot.
 */
namespace Skeleton\Tools\Knot\Connectors {
	if (!function_exists(__NAMESPACE__ . '\\get_param_class'))
	{
		/**
		 * @param \ReflectionMethod|\ReflectionParameter $source
		 */
		function get_param_class($source): ?\ReflectionClass
		{
			if ($source instanceof \ReflectionMethod)
			{
				$parameter = $source->getParameters()[0];
			}
			else if ($source instanceof \ReflectionParameter)
			{
				$parameter = $source;
			}
			else
			{
				throw new \Exception("Get param class from unsupported source");
			}
			
			$type = $parameter->getType();
			
			if (!($type instanceof \ReflectionNamedType))
				return null;
			
			if (\Skeleton\BuiltInType::isConstValueExists($type->getName()))
				return null;
			
			return new \ReflectionClass($type->getName());
		}
	}
}

namespace {
	use Squids\SquidsScope;
	use Squids\Base\Module\ICLIController;
	
	/** @var ICLIController $controller */
	$controller = SquidsScope::skeleton(ICLIController::class);
	exit($controller->run());
}
