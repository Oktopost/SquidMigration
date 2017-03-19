<?php
namespace Squids\Module;


use Squids\Base\Module\IReporter;
use Squids\Objects\IAction;
use Squids\Objects\MigrationMetadata;


class ReportModule implements IReporter
{
	private $startTime;
	private $scriptStartTime;
	

	public function nothingToUpdate()
	{
		echo "DB is up to date\n";
	}

	/**
	 * @param IAction[] $targetActions
	 */
	public function beforeMigration(array $targetActions)
	{
		$count = count($targetActions);
		echo "About to execute total of $count actions...\n\n";
	}

	/**
	 * @param IAction[] $targetActions
	 */
	public function afterMigration(array $targetActions)
	{
		echo "Migration complete\n";
	}
	
	public function beforeSqlScript(string $scriptPath)
	{
		$this->scriptStartTime = microtime(true);
		echo "    Running script file: $scriptPath\n";
	}
	
	public function afterSqlScript(string $scriptPath)
	{
		$endTime = microtime(true);
		echo "        Complete in " . round($endTime - $this->scriptStartTime, 3) . " sec\n";
	}

	public function beforeAction(IAction $action)
	{
		$this->startTime = microtime(true);
		echo 'Running: ' . $action->__toString() . "\n";
	}

	public function afterAction(IAction $action, MigrationMetadata $data)
	{
		$endTime = microtime(true);
		echo "    Complete in " . round($endTime - $this->startTime, 3) . " sec\n\n";
	}

	public function onError(\Exception $e)
	{
		echo "\n\n";
		echo "*********************************\n";
		echo "Error encountered!\n";
		echo "Code: {$e->getCode()}";
		echo "File: {$e->getFile()}";
		echo "Line: {$e->getLine()}";
		echo "Message: {$e->getMessage()}";
		echo "*********************************\n";
		echo "\n\n";
	}

	public function onNewAction(IAction $action)
	{
		echo "New Action created: $action\n";
	}
}