<?php
namespace Squids\Base\Module\Actions;


use Squids\Objects\IAction;


/**
 * @skeleton
 */
interface ITree
{
	public function setCollection(IActionCollection $collection);
	
	/**
	 * @return IAction[]
	 */
	public function head(): array;
	
	/**
	 * @return IAction[]
	 */
	public function tail(): array;

	/**
	 * @param IAction $of
	 * @return IAction[]
	 */
	public function parents(IAction $of): array;

	/**
	 * @param IAction $of
	 * @return IAction[]
	 */
	public function children(IAction $of): array;
	
	public function addNewAction(IAction $action);
	
	public function load();
}