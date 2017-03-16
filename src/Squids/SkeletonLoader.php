<?php
namespace Squids;


use Skeleton\ConfigLoader\PrefixDirectoryConfigLoader;


class SkeletonLoader extends PrefixDirectoryConfigLoader
{
	protected function createPath($directory, $path)
	{
		if (strpos($directory, 'phar://') !== 0)
		{
			return parent::createPath($directory, $path);
		}
		
		return "phar://squid/$path.php";
	}
}