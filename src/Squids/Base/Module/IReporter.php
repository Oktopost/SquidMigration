<?php
namespace Squids\Base\Module;


use Squids\Objects\IAction;
use Squids\Objects\MigrationMetadata;


/**
 * @skeleton
 */
interface IReporter
{
	public function nothingToUpdate(): void;

	/**
	 * @param IAction[] $targetActions
	 */
	public function beforeMigration(array $targetActions): void;

	/**
	 * @param IAction[] $targetActions
	 */
	public function afterMigration(array $targetActions): void;
	
	public function onNewAction(IAction $action);
	public function beforeSqlScript(string $scriptPath): void;
	public function afterSqlCommand(): void;
	public function afterSqlScript(string $scriptPath): void;
	public function beforeAction(IAction $action): void;
	public function afterAction(IAction $action, MigrationMetadata $data): void;
	public function onError(\Exception $e): void;
	
}