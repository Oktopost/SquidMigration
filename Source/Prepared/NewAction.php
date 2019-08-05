<?php
namespace Squids\Prepared;


use Squids\Objects\IAction;
use Squids\Exceptions\SquidsException;

use Squid\MySql\IMySqlConnector;


class NewAction implements IAction
{
	private $id;
	private $name;
	private $fullName;
	private $dependencies = [];
	
	
	public function setID(string $id)
	{
		$this->id = $id;
	}
	
	public function setName(string $name)
	{
		$this->name = $name;
	}
	
	public function setFullName(string $fullName)
	{
		$this->fullName = $fullName;
	}

	/**
	 * @param IAction[] $dependencies
	 */
	public function setDependencies(array $dependencies)
	{
		foreach ($dependencies as $dependency)
		{
			$this->dependencies[] = $dependency->id();
		}
	}
	
	
	
	public function id(): string
	{
		return $this->id;
	}

	public function name(): string
	{
		return $this->name;
	}

	public function fullName(): string
	{
		return $this->fullName;
	}
	
	public function dir(): string
	{
		throw new \Exception('Should not be called!');
	}

	/**
	 * @return string[]
	 */
	public function dependencies(): array
	{
		return $this->dependencies;
	}
	
	public function author(): string
	{
		return '';
	}
	
	public function description(): string
	{
		return '';
	}
	
	/**
	 * @return array
	 */
	public function scriptFiles(): array
	{
		return [];
	}

	public function __toString()
	{
		return "Action ID {$this->id()}, name {$this->name()}";
	}

	public function execute(IMySqlConnector $connector)
	{
		throw new SquidsException('Non executable', 105);
	}
}