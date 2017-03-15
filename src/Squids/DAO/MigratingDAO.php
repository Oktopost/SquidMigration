<?php
namespace Squids\DAO;


use Squids\Base\DAO\IMigratingDAO;
use Squids\Objects\IAction;


/**
 * @autoload
 * @unique
 */
class MigratingDAO implements IMigratingDAO
{
	/** 
	 * @autoload
	 * @var \Squids\Base\DAO\IConnector
	 */
	private $connector;
	
	
	public function executeScript(string $path)
	{
		// TODO: $this->connector->target();
	}

	public function executeAction(IAction $action)
	{
		$action->execute($this->connector->target());
	}
}