<?php
namespace Squids\Module;


use Squids\SquidsScope;
use Squids\Base\Module\IActionsFS;
use Squids\Objects\IAction;
use Squids\Exceptions\SquidsException;


class ActionsFSModule implements IActionsFS
{
	const DEFAULT_NAMESPACE = 'SquidMigrationActions';
	
	
	private function getNamespace(string $path): string
	{
		$parts = explode('/', $path);
		
		$year	= $parts[count($parts) - 4];
		$month	= $parts[count($parts) - 3];
		$day	= $parts[count($parts) - 2];
		
		return self::DEFAULT_NAMESPACE . "_{$year}_{$month}_{$day}";
	}
	
	private function isNumbers(string $baseName, int $length): bool
	{
		return preg_match("/[0-9]{{$length}}/", $baseName) === 1;
	}
	
	/**
	 * @param string $path
	 * @return IAction
	 */
	private function loadAction(string $path): IAction
	{
		$name = basename($path);
		$filePath = "$path/$name.php";
		$className = $this->getNamespace($path) . '\\' . $name;
		
		if (!file_exists($filePath))
			throw new SquidsException("Action php file [$name.php] not found under path [$path]");
		
		require_once $filePath;
		
		if (!class_exists($className))
			throw new SquidsException("Action named [$className] not found in file [$filePath]");
			
		return new $className;
	}
	
	/**
	 * @param string $path
	 * @return IAction[]
	 */
	private function iterateOverDay(string $path): array 
	{
		$data = [];
		
		foreach (glob($path . '/*') as $item)
		{
			if (is_dir($item))
			{
				$data[] = $this->loadAction($item);
			}
		}
		
		return $data;
	}
	
	/**
	 * @param string $path
	 * @return IAction[]
	 */
	private function iterateOverMonth(string $path): array
	{
		$data = [];
		
		foreach (glob($path . '/*') as $item)
		{
			if (is_dir($item) && $this->isNumbers(basename($item), 2))
			{
				$data = array_merge($data, $this->iterateOverDay($item));
			}
		}
		
		return $data;
	}
	
	/**
	 * @param string $path
	 * @return IAction[]
	 */
	private function iterateOverYear(string $path): array
	{
		$data = [];
		
		foreach (glob($path . '/*') as $item)
		{
			$base = basename($item);
			$baseAsNumber = (int)$base;
			
			if (is_dir($item) && $this->isNumbers($base, 2) && $baseAsNumber >= 1 && $baseAsNumber <= 12)
			{
				$data = array_merge($data, $this->iterateOverMonth($item));
			}
		}
		
		return $data;
	}
	
	/**
	 * @param string $path
	 * @return IAction[]
	 */
	private function iterateOverMainDir(string $path): array
	{
		$data = [];
		
		foreach (glob($path . '/*') as $item)
		{
			$base = basename($item);
			$baseAsNumber = (int)$base;
			
			if (is_dir($item) && $this->isNumbers($base, 4) && $baseAsNumber >= 1950)
			{
				$data = array_merge($data, $this->iterateOverYear($item));
			}
		}
		
		return $data;
	}
	
	
	/**
	 * @return IAction[]
	 */
	public function get(): array
	{
		$migrationsDir = SquidsScope::config()->Paths->MigrationsDir;
		$actions = $this->iterateOverMainDir($migrationsDir);
		return array_reverse($actions);
	}

	/**
	 * Create the directories for new Action.
	 * @param IAction $newAction
	 */
	public function init(IAction $newAction)
	{
		
	}

	/**
	 * Delete action directories
	 * @param IAction $action
	 */
	public function delete(IAction $action)
	{
		// TODO: Implement delete() method.
	}
}