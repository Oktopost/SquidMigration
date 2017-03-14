<?php
namespace Squids\Base\Module\Actions;


use Squids\Objects\IAction;


/**
 * @skeleton
 */
interface ILoader
{
	/**
	 * @return IAction[]
	 */
	public function get(): array;
}