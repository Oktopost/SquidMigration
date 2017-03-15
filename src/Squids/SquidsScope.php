<?php
namespace Squids;


use Squids\Base\Module\Config\ISetup;
use Squids\Config\Main;

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
	
	
	public static function config(): Main
	{
		/** @var ISetup $setup */
		$setup = self::skeleton(ISetup::class);
		return $setup::config();
	}
}