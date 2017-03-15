<?php
namespace Squids\Module\Actions;


use Squids\Base\Module\Actions\IActionCollection;
use Squids\Base\Module\Actions\ITree;
use Squids\Objects\IAction;


class Tree implements ITree
{
	/** @var IActionCollection */
	private $collection;
	
	
	/** @var string[][] */
	private $children = [];
	
	/** @var string[][] */
	private $parents = [];
	
	/** @var string[] */
	private $headSet = [];
	
	/** @var string[] */
	private $tailSet = [];
	
	
	/**
	 * @param array $ids
	 * @return IAction[]
	 */
	private function getActionsByIDs(array $ids): array 
	{
		return $this->collection->getAll($ids);
	}
	

	public function setCollection(IActionCollection $collection)
	{
		$this->collection = $collection;
	}

	/**
	 * @return IAction[]
	 */
	public function head(): array
	{
		return $this->getActionsByIDs(array_keys($this->headSet));
	}
	
	/**
	 * @return IAction[]
	 */
	public function tail(): array
	{
		return $this->getActionsByIDs(array_keys($this->tailSet));
	}

	/**
	 * @param IAction $of
	 * @return IAction[]
	 */
	public function parents(IAction $of): array
	{
		return $this->getActionsByIDs($this->parents[$of->id()]);
	}

	/**
	 * @param IAction $of
	 * @return IAction[]
	 */
	public function children(IAction $of): array
	{
		return $this->getActionsByIDs($this->children[$of->id()]);
	}

	public function addNewAction(IAction $action)
	{
		foreach ($action->dependencies() as $id)
		{
			unset($this->headSet[$id]);
			$this->children[$id][] = $action->id();
		}
		
		$this->parents[$action->id()] = $action->dependencies();
		$this->headSet[$action->id()] = true;
	}
	
	public function load()
	{
		foreach ($this->collection->all() as $action)
		{
			$id = $action->id();
			$parents = $action->dependencies();
			
			$this->parents[$id] = $parents;
			$this->children[$id] = [];
			
			if (!$parents)
			{
				$this->tailSet[$id] = true;
			}
		}
		
		foreach ($this->parents as $id => $parents)
		{
			foreach ($parents as $parent)
			{
				$this->children[$parent] = $id;
			}
		}
		
		foreach ($this->children as $id => $children)
		{
			if (!$children)
			{
				$this->headSet[$id] = true;
			}
		}
	}
}