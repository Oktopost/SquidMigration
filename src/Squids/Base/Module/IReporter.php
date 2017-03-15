<?php
namespace Squids\Base\Module;


use Squids\Objects\IAction;
use Squids\Objects\MigrationMetadata;


/**
 * @skeleton
 */
interface IReporter
{
	public function nothingToUpdate();

	/**
	 * @param IAction[] $targetActions
	 */
	public function beforeMigration(array $targetActions);

	/**
	 * @param IAction[] $targetActions
	 */
	public function afterMigration(array $targetActions);
	
	public function onNewAction(IAction $action);
	public function beforeAction(IAction $action);
	public function afterAction(IAction $action, MigrationMetadata $data);
	public function onError(\Exception $e);
	
}