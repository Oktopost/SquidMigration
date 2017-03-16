<?php
namespace Squids\Module;


use Squids\Exceptions\SquidsException;
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
	 * @param IAction $action
	 * @return string[]
	 */
	private function getScripts(IAction $action): array
	{
		$scripts = [];
		
		foreach ($action->scriptFiles() as $file)
		{
			$scripts = array_merge($scripts, glob($action->dir() . '/' . $file));
		}
		
		return $scripts;
	}
	
	private function runScripts(IAction $action)
	{
		$scripts = $this->getScripts($action);
		
		foreach ($scripts as $script)
		{
			if (!file_exists($script))
				throw new SquidsException("Script file [$script] was not found. Used in action $action");
		}
		
		foreach ($scripts as $script)
		{
			$this->reporter->beforeSqlScript($script);
			$this->migratingDAO->executeScript($script);
			$this->reporter->afterSqlScript($script);
		}
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
		$this->runScripts($action);
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