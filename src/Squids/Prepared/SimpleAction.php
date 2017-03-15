<?php
namespace Squids\Prepared;


use Squids\Exceptions\SquidsException;
use Squids\Objects\IAction;


abstract class SimpleAction implements IAction
{
	const ID = 'UNDEFINED';
	
	
	public function id(): string
	{
		if (static::ID == self::ID)
			throw new SquidsException('Const ID must be defined in Action for SimpleAction class!');
		
		return static::ID;
	}

	public function name(): string
	{
		return (new \ReflectionClass(get_class($this)))->getShortName();
	}

	public function fullName(): string
	{
		return (new \ReflectionClass(get_class($this)))->getName();
	}
	
	/**
	 * @return array|string
	 */
	public function scriptFiles()
	{
		return [
			'*.sql'
		];
	}

	public function __toString()
	{
		return "Action ID {$this->id()}, name {$this->fullName()}";
	}
}