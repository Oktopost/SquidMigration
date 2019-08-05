<?php
namespace Squids\Config;


use Objection\LiteSetup;
use Objection\LiteObject;


/**
 * @property DB		$DB
 * @property Paths	$Paths
 */
class Main extends LiteObject
{
	/**
	 * @return array
	 */
	protected function _setup()
	{
		return [
			'DB'	=> LiteSetup::createInstanceOf(DB::class),
			'Paths'	=> LiteSetup::createInstanceOf(Paths::class)
		];
	}
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->DB = new DB();
		$this->Paths = new Paths();
	}
}