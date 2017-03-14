<?php
namespace Squids\Exceptions;


use Squids\Objects\IAction;


class DuplicateActionException extends \Exception
{
	public function __construct(IAction $dup, IAction $of)
	{
		parent::__construct("Action $dup is a duplicate of action $of!", 100);
	}
}