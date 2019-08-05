<?php
namespace Squids\Module;


use Squids\Base\Module\IReporter;
use Squids\Objects\IAction;
use Squids\Objects\MigrationMetadata;


class ReportModule implements IReporter
{
	private $startTime;
	private $scriptStartTime;
	private $totalActions;
	private $dotsCount;
	private $hadScripts;
	
	private $currentAction = 0;
	
	
	private function getActionNumber(): string
	{
		$length = strlen($this->totalActions);
		
		return '[ ' . 
			str_pad($this->currentAction, $length, ' ', STR_PAD_LEFT) . 
			' / ' . 
			$this->totalActions . 
		' ]';
	}
	
	
	public function nothingToUpdate(): void
	{
		echo "DB is up to date\n";
	}

	/**
	 * @param IAction[] $targetActions
	 */
	public function beforeMigration(array $targetActions): void
	{
		$count = count($targetActions);
		$this->totalActions = $count;
		
		echo "\nFound $count actions\n";
		echo "================================\n\n";
	}

	public function beforeAction(IAction $action): void
	{
		$this->hadScripts = false;
		$this->currentAction++;
		$this->startTime = microtime(true);
		
		echo $this->getActionNumber() . ' ' . $action->__toString() . "\n\n";
	}
	
	public function beforeSqlScript(string $scriptPath): void
	{
		if ($this->hadScripts)
			echo "\n";
		else
			$this->hadScripts = true;
		
		$this->dotsCount = 0;
		
		$name = substr($scriptPath, strrpos($scriptPath, '/') + 1);
		
		echo "    > $name\n    ";
		
		$this->scriptStartTime = microtime(true);
	}
	
	public function afterSqlCommand(): void
	{
		$this->dotsCount++;
		
		if ($this->dotsCount >= 51)
		{
			$this->dotsCount = 0;
			echo "\n    ";
		}
		
		echo '.';
	}
	
	public function afterSqlScript(string $scriptPath): void
	{
		$endTime = microtime(true);
		
		$spaces = str_pad('', 50 - $this->dotsCount, ' ');
			
		echo $spaces . '[' . round($endTime - $this->scriptStartTime, 3) . " sec]\n";
	}

	public function afterAction(IAction $action, MigrationMetadata $data): void
	{
		if ($this->hadScripts)
		{
			$endTime = microtime(true);
			echo "\n    Complete in " . round($endTime - $this->startTime, 3) . " sec\n\n";
		}
	}

	/**
	 * @param IAction[] $targetActions
	 */
	public function afterMigration(array $targetActions): void
	{
		echo "================================\n";
		echo "Migration complete\n\n";
	}
	
	public function onError(\Exception $e): void
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

	public function onNewAction(IAction $action): void
	{
		echo "New Action created: $action\n";
	}
}