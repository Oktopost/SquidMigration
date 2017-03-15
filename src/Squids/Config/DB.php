<?php
namespace Squids\Config;


class DB
{
	/** @var callable */
	private $getMetadataDBCallback;
	
	/** @var callable */
	private $getMainDBCallback;
	
	
	public function __construct()
	{
		$this->setMetadataDB([]);
		$this->setMainDB([]);
	}
	

	public function setMetadataDB(array $config)
	{
		$this->getMetadataDBCallback = function () use ($config) { return $config; };
	}
	
	public function setMainDB(array $config)
	{
		$this->getMainDBCallback = function () use ($config) { return $config; };
	}
	
	
	public function getMainDBConfig(): array
	{
		$callback = $this->getMainDBCallback;
		return $callback();
	}
	
	public function getMetadataCallback(): array
	{
		$callback = $this->getMetadataDBCallback;
		return $callback();
	}
}