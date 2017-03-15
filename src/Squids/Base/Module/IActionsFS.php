<?php
namespace Squids\Base\Module;


use Squids\Objects\IAction;


/**
 * @skeleton
 */
interface IActionsFS
{
	/**
	 * @return IAction[]
	 */
	public function get(): array;

	/**
	 * Create the directories for new Action. 
	 * @param IAction $newAction
	 */
	public function init(IAction $newAction);

	/**
	 * Delete action directories
	 * @param IAction $action
	 */
	public function delete(IAction $action);
}