<?php
namespace Squids\Base\DAO;


use Squids\Objects\IAction;


/**
 * @skeleton
 */
interface IMigratingDAO
{
	public function executeScript(string $path, ?callable $callback = null): void;
	public function executeAction(IAction $action): void;
}