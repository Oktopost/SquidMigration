<?php
namespace Squids\Objects;


use Squid\MySql\IMySqlConnector;


interface IAction
{
	public function id(): string;
	public function name(): string;
	public function fullName(): string;
	public function dir(): string;
	public function author(): string;
	public function description(): string;

	/**
	 * @return array
	 */
	public function scriptFiles(): array;
	
	/**
	 * @return string[]
	 */
	public function dependencies(): array;
	
	public function execute(IMySqlConnector $connector);
	
	public function __toString();
}