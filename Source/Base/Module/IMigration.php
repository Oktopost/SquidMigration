<?php
namespace Squids\Base\Module;


use Squids\Objects\IAction;


/**
 * @skeleton
 */
interface IMigration
{
	/**
	 * @param string|IAction $identifier ID or Name
	 */
	public function runOnly($identifier);
	
	public function update();
}