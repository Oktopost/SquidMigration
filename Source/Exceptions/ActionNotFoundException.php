<?php
namespace Squids\Exceptions;


class ActionNotFoundException extends SquidsException
{
	public static function forID($id)
	{
		throw new ActionNotFoundException("Action with ID [$id] not found!", 101);
	}
	
	public static function forFullName($name)
	{
		throw new ActionNotFoundException("Action with name '$name' not found!", 102);
	}
}