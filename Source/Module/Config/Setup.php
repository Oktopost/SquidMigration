<?php
namespace Squids\Module\Config;


use Squids\Base\Module\Config\ISetup;
use Squids\Config\Main;


class Setup implements ISetup
{
	public static function config(): Main
	{
		static $config = null;
		
		if (!$config)
		{
			$loader = new ConfigLoader();
			$config = $loader->get();
		}
		
		return $config;
	}
}