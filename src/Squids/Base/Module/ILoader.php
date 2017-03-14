<?php
namespace Squids\Base\Module;


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