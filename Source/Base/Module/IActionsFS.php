<?php
namespace Squids\Base\Module;


use Squids\Objects\IAction;
use Squids\Prepared\NewAction;


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
	 * @param NewAction $newAction
	 */
	public function init(NewAction $newAction);
}