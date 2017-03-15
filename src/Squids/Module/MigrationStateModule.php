<?php
namespace Squids\Module;


use Squids\SquidsScope;
use Squids\Base\DAO\IMigrationMetadataDAO;
use Squids\Base\Module\IMigrationState;
use Squids\Objects\IAction;


/**
 * @autoload
 */
class MigrationStateModule implements IMigrationState
{
	/**
	 * @var \Squids\Base\Module\IActions
	 * @autoload
	 */
	private $actions;
	
	
	private function getExistingActionIDs(): array
	{
		/** @var IMigrationMetadataDAO $metadataDAO */
		$metadataDAO = SquidsScope::skeleton(IMigrationMetadataDAO::class);
		$actions = $metadataDAO->loadAll();
		$data = [];
		
		foreach ($actions as $action)
		{
			$data[$action->ActionID] = true;
		}
		
		return $data;
	}

	private function bufferDependencies(IAction $action, array &$existingSet, array &$buffer)
	{
		foreach ($action->dependencies() as $dependency)
		{
			if (!isset($existingSet[$dependency]))
			{
				$dependencyAction = $this->actions->collection()->get($dependency);
				$this->bufferDependencies($dependencyAction, $existingSet, $buffer);
			}
		}
		
		if (!isset($existingSet[$action->id()]))
		{
			$existingSet[$action->id()] = true;
			$buffer[] = $action->id();
		}
	}
	
	
	/**
	 * @param array $ids
	 * @return IAction[]
	 */
	private function getActionsByActionID(array $ids): array 
	{
		return $this->actions->collection()->getAll($ids);
	}
	
	public function isUpToDate(): bool
	{
		return !((bool)$this->diff());
	}

	/**
	 * @return IAction[]
	 */
	public function diff(): array
	{
		$actionIDsSet = $this->getExistingActionIDs();
		
		$headActions = $this->actions->tree()->head();
		$buffer = [];
		
		foreach ($headActions as $action)
		{
			$this->bufferDependencies($action, $actionIDsSet, $buffer);
		}
		
		return $this->getActionsByActionID($buffer);
	}
}