<?php
namespace SquidMigrationActions_2015_02_03;


use Squids\Prepared\SimpleAction;


class Test extends SimpleAction
{
	const ID = '12312831203';
	
	
	/**
	 * @return string[]
	 */
	public function dependencies(): array
	{
		return ['a'];
	}
}