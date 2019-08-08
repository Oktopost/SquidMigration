<?php
namespace Squids\Module;


use Squids\SquidsScope;
use Squids\Base\Module\ICLIController;


/**
 * @autoload
 */
class CLIController implements ICLIController
{
	private function init($name)
	{
		/** @var \Squids\Base\Module\IActions $migration */
		$actions = SquidsScope::skeleton(\Squids\Base\Module\IActions::class);
		$actions->generate($name);
	}
	
	private function update()
	{
		/** @var \Squids\Base\Module\IMigration $migration */
		$migration = SquidsScope::skeleton(\Squids\Base\Module\IMigration::class);
		$migration->update();
	}
	
	private function setup()
	{
		/** @var \Squids\Base\Module\IDBSetup $migration */
		$migration = SquidsScope::skeleton(\Squids\Base\Module\IDBSetup::class);
		$migration->run();
	}
	
	private function printHelp()
	{
		echo "\n";
		echo "SquidMigration v0.3\n";
		echo "-------------------\n";
		echo "Usage:\n";
		echo "    squid update             - Run all needed migrations\n";
		echo "    squid init ActionName    - Create a new migration action called \"ActionName\"\n";
		echo "    squid setup              - Create SquidMigration metadata DB interactively\n";
		echo "\n";
	}
	
	private function printError(\Exception $e)
	{
		echo "\n";
		echo "Error caught when running squid!\n";
		echo "{$e->getCode()}: {$e->getMessage()}\n";
		echo "\n";
	}
	
	private function runUnsafe()
	{
		global $argv;
		
		$initPos = array_search('init', $argv);
		
		if ($initPos)
		{
			if (!isset($argv[$initPos + 1]) || !$argv[$initPos + 1])
			{
				$this->printHelp();
			}
			else
			{
				$this->init($argv[$initPos + 1]);
			}
		}
		else if (array_search('update', $argv) !== false)
		{
			$this->update();
		}
		else if (array_search('setup', $argv) !== false)
		{
			$this->setup();
		}
		else 
		{
			$this->printHelp();
		}
	}
	
	
	public function run()
	{
		try
		{
			$this->runUnsafe();
		}
		catch (\Exception $e)
		{
			$this->printError($e);
		}
	}
}