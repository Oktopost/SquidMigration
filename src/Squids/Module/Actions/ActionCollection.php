<?php
namespace Squids\Module\Actions;


use Squids\Base\Module\ILoader;
use Squids\Base\Module\Actions\IActionCollection;
use Squids\Objects\IAction;
use Squids\Exceptions\ActionNotFoundException;
use Squids\Exceptions\DuplicateActionException;


class ActionCollection implements IActionCollection
{
	/** @var IAction[] By Action ID */
	private $actions = [];
	
	/** @var string[] */
	private $nameToID = [];
	
	
	private function isDuplicate(IAction $action)
	{
		if ($this->has($action->id()))
		{
			throw new DuplicateActionException($this->actions[$action->id()], $action);
		}
		
		if ($this->hasFullName($action->fullName()))
		{
			throw new DuplicateActionException($this->getByFullName($action->fullName()), $action);
		}
	}
	

	public function get($id): IAction
	{
		if (!$this->has($id))
			ActionNotFoundException::forID($id);
		
		return $this->actions[$id];
	}

	/**
	 * @param array $ids
	 * @return IAction[]
	 */
	public function getAll(array $ids): array
	{
		$data = [];
		
		foreach ($ids as $id)
		{
			$data[] = $this->get($id);
		}
		
		return $data;
	}
	
	public function getByFullName($name): IAction
	{
		if (!$this->hasFullName($name))
			ActionNotFoundException::forFullName($name);
		
		$id = $this->nameToID[$name];
		return $this->get($id);
	}
	
	public function has($id): bool
	{
		return isset($this->actions[$id]);
	}
	
	public function hasFullName($name): bool
	{
		return isset($this->nameToID[$name]);
	}
	
	public function add(IAction $action)
	{
		$this->isDuplicate($action);
		$this->actions[$action->id()] = $action;
		$this->nameToID[$action->fullName()] = $action->id();
	}

	public function load(ILoader $loader)
	{
		foreach ($loader->get() as $action)
		{
			$this->add($action);
		}
	}

	/**
	 * @return IAction[]
	 */
	public function all(): array
	{
		return array_values($this->actions);
	}
}