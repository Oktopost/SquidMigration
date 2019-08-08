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
		$actionID		= $action->id();
		$dependencies	= [$actionID => true];
		$map			= [];
		
		while ($dependencies)
		{
			foreach (array_keys($dependencies) as $dependency)
			{
				if (!isset($map[$dependency]))
				{
					$dependencyAction = $this->actions->collection()->get($dependency);
					$subDependencies = $dependencyAction->dependencies();
					$map[$dependencyAction->id()] = $subDependencies;
					$dependencies[$dependencyAction->id()] = true;
				}
				
				foreach ($map[$dependency] as $index => $subDependency)
				{
					if (isset($existingSet[$subDependency]))
					{
						unset($map[$dependency][$index]);
					}
					else 
					{
						$dependencies[$subDependency] = true;
					}
				}
				
				if (count($map[$dependency]) == 0)
				{
					unset($dependencies[$dependency]);
					unset($map[$dependency]);
					
					if (!isset($existingSet[$dependency]))
					{
						$existingSet[$dependency] = true;
						$buffer[] = $dependency;
					}
				}
			}
		}
		
		if (!isset($existingSet[$actionID]))
		{
			$existingSet[$actionID] = true;
			$buffer[] = $actionID;
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