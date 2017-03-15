<?php
namespace Squids\Prepared;


use Squid\MySql\IMySqlConnector;

use Squids\Objects\IAction;
use Squids\Exceptions\SquidsException;


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

	/**
	 * @return string[]
	 */
	public function dependencies(): array
	{
		return $this->dependencies;
	}
	
	/**
	 * @return array|string
	 */
	public function scriptFiles()
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