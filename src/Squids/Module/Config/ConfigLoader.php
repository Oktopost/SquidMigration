<?php
namespace Squids\Module\Config;


use Squids\Config\Main;


class ConfigLoader
{
	public function get(): Main
	{
		return new Main();
	}
}