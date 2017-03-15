<?php
namespace Squids\Objects;


use Objection\LiteSetup;
use Objection\LiteObject;


/**
 * @property int|null	$ID
 * @property string 	$ActionID
 * @property string 	$Name
 * @property string 	$FullName
 * @property string 	$StartDate
 * @property string 	$EndDate
 */
class MigrationMetadata extends LiteObject
{
	/**
	 * @return array
	 */
	protected function _setup()
	{
		return [
			'ID'		=> LiteSetup::createInt(null),
			'ActionID'	=> LiteSetup::createString(),
			'Name'		=> LiteSetup::createString(),
			'FullName'	=> LiteSetup::createString(),
			'StartDate'	=> LiteSetup::createString(),
			'EndDate'	=> LiteSetup::createString()
		];
	}
	
	
	public function start()
	{
		$this->StartDate = date("Y-m-d H:i:s");
	}
	
	public function end()
	{
		$this->EndDate = date("Y-m-d H:i:s");
	}
	
	public static function fromAction(IAction $action): MigrationMetadata
	{
		$mm = new MigrationMetadata();
		
		$mm->ActionID = $action->id();
		$mm->FullName = $action->fullName();
		$mm->Name = $action->name();
		
		return $mm;
	}
}