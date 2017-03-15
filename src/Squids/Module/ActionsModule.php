<?php
namespace Squids\Module;


use Squids\Base\Module\IActions;
use Squids\Base\Module\IActionsFS;
use Squids\Base\Module\Actions\ITree;
use Squids\Base\Module\Actions\IActionCollection;

use Squids\SquidsScope;


/**
 * @autoload
 * @unique
 */
class ActionsModule implements IActions
{
	private $isLoaded = false;
	
	/**
	 * @autoload
	 * @var \Squids\Base\Module\Actions\ITree
	 */
	private $tree;

	/**
	 * @autoload
	 * @var \Squids\Base\Module\Actions\IActionCollection
	 */
	private $collection;
	
	
	private function load()
	{
		if ($this->isLoaded)
			return;
		
		/** @var IActionsFS $loader */
		$loader = SquidsScope::skeleton(IActionsFS::class);
		
		$this->collection->load($loader);
		$this->tree->setCollection($this->collection);
		$this->tree->load();
		
		$this->isLoaded = true;
	}
	

	public function collection(): IActionCollection
	{
		$this->load();
		return $this->collection;
	}

	public function tree(): ITree
	{
		$this->load();
		return $this->tree;
	}
}