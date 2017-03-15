<?php
namespace Squids\Objects;


use Squid\MySql\IMySqlConnector;


interface IAction
{
	public function id(): string;
	public function name(): string;
	public function fullName(): string;

	/**
	 * @return array|string
	 */
	public function scriptFiles();
	
	/**
	 * @return string[]
	 */
	public function dependencies(): array;
	
	public function execute(IMySqlConnector $connector);
	
	public function __toString();
}