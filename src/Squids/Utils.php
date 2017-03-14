<?php
namespace Squids;


class Utils
{
	public static function generateID(): string
	{
		return md5(uniqid(time() . '.', true));
	}
}