<?php
namespace Squids\Base\Module;


use Squids\Objects\IAction;


/**
 * @skeleton
 */
interface IMigrationState
{
	public function isUpToDate(): bool;
	
	/**
	 * @return IAction[]
	 */
	public function diff(): array;
}