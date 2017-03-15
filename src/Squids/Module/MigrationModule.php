<?php
namespace Squids\Module;


use Squids\Objects\MigrationMetadata;
use Squids\SquidsScope;
use Squids\Base\Module\IMigration;
use Squids\Base\Module\IMigrationState;
use Squids\Objects\IAction;


/**
 * @autoload
 */
class MigrationModule implements IMigration
{
	/**
	 * @var \Squids\Base\DAO\IMigrationMetadataDAO
	 * @autoload 
	 */
	private $metaDataDAO;
	
	/**
	 * @var \Squids\Base\Module\IActions
	 * @autoload 
	 */
	private $actions;

	/**
	 * @var \Squids\Base\DAO\IMigratingDAO 
	 * @autoload
	 */
	private $migratingDAO;

	/**
	 * @var \Squids\Base\Module\IReporter
	 * @autoload
	 */
	private $reporter;
	
	
	private function resolveAction($identifier): IAction
	{
		if ($identifier instanceof IAction)
			return $identifier;
		
		if ($this->actions->collection()->has($identifier))
			return $this->actions->collection()->get($identifier);
		
		return $this->actions->collection()->getByFullName($identifier);
	}
	
	
	/**
	 * @param string|IAction $identifier ID or Name
	 */
	public function runOnly($identifier)
	{
		$action = $this->resolveAction($identifier);
		$metaData = MigrationMetadata::fromAction($action);
		
		$this->reporter->beforeAction($action);
		
		$metaData->start();
		$this->migratingDAO->executeAction($action);
		$metaData->end();
		
		$this->reporter->afterAction($action, $metaData);
		
		$this->metaDataDAO->save($metaData);
	}
	

	public function update()
	{
		/** @var IMigrationState $stateModule */
		$stateModule = SquidsScope::skeleton(IMigrationState::class);
		$diff = $stateModule->diff();
		
		if (!$diff)
		{
			
			$this->reporter->nothingToUpdate();
			return;
		}
		
		$this->reporter->beforeMigration($diff);
		
		foreach ($diff as $action)
		{
			$this->runOnly($action);
		}
		
		$this->reporter->afterMigration($diff);
	}
}