<?php
namespace Squids\Prepared;


use Squids\Exceptions\SquidsException;
use Squids\Objects\IAction;


abstract class SimpleAction implements IAction
{
	const ID	= 'UNDEFINED';
	const DEP	= [];
	
	
	public function id(): string
	{
		if (static::ID == self::ID)
			throw new SquidsException('Const ID must be defined in Action for SimpleAction class!');
		
		return static::ID;
	}
	
	public function dependencies(): array
	{
		return static::DEP;
	}

	public function name(): string
	{
		return (new \ReflectionClass(get_class($this)))->getShortName();
	}

	public function fullName(): string
	{
		return (new \ReflectionClass(get_class($this)))->getName();
	}
	
	public function dir(): string
	{
		return dirname((new \ReflectionClass(get_class($this)))->getFileName());
	}
	
	/**
	 * @return array
	 */
	public function scriptFiles(): array
	{
		return [
			'*.sql'
		];
	}

	public function __toString()
	{
		return "Action ID {$this->id()}, name {$this->name()}";
	}
}