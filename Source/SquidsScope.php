<?php
namespace Squids;


use Squids\Base\Module\Config\ISetup;
use Squids\Config\Main;

use Skeleton\Skeleton;


class SquidsScope
{
	use \Skeleton\TSkeletonScope;
	
	
	private static function setupSkeleton(Skeleton $skeleton)
	{
		$skeleton
			->enableKnot()
			->setConfigLoader(new SkeletonLoader('Squids', __DIR__ . '/../../skeleton'));
	}
	
	
	public static function config(): Main
	{
		/** @var ISetup $setup */
		$setup = self::skeleton(ISetup::class);
		return $setup::config();
	}
}