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
	
	
	public function executeScript(string $path, ?callable $callback = null): void
	{
		if (!file_exists($path) || !is_readable($path))
			throw new \Exception("The file at [$path] is unreadable or doesn't exists");
		
		$data = file_get_contents($path);
		
		$this->connector->target()
			->bulk()
			->add($data)
			->executeWithCallback(function ()
				use ($callback)
			{
				if ($callback)
				{
					$callback();
				}
			});
	}

	public function executeAction(IAction $action): void
	{
		$action->execute($this->connector->target());
	}
}