<?php
namespace Squids\DAO;


use Squids\Base\DAO\IMigratingDAO;
use Squids\Objects\IAction;

use Squid\MySql\Impl\Connectors\FileConnector;


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
		$fileConnector = new FileConnector($this->connector->target());
		$fileConnector->execute($path);
	}

	public function executeAction(IAction $action)
	{
		$action->execute($this->connector->target());
	}
}