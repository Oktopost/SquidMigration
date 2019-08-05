<?php
namespace Squids\Base\Module\Config;


use Squids\Config\Main;


/**
 * @skeleton
 */
interface ISetup
{
	public static function config(): Main;
}