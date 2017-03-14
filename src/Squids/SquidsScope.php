<?php
namespace Squids;


use Skeleton\Skeleton;
use Skeleton\ConfigLoader\PrefixDirectoryConfigLoader;


class SquidsScope
{
	use \Skeleton\TSkeletonScope;
	
	
	private static function setupSkeleton(Skeleton $skeleton)
	{
		$skeleton
			->enableKnot()
			->setConfigLoader(new PrefixDirectoryConfigLoader('Squid', __DIR__ . '/../skeleton'));
	}
}