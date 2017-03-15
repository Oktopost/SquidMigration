<?php
namespace Squids\Config;


use Objection\LiteSetup;
use Objection\LiteObject;


/**
 * @property string $MigrationsDir
 * @property string $DBConfigFile
 */
class Paths extends LiteObject
{
	/**
	 * @return array
	 */
	protected function _setup()
	{
		return [
			'MigrationsDir'	=> LiteSetup::createString(),
			'DBConfigFile'	=> LiteSetup::createString()
		];
	}
}