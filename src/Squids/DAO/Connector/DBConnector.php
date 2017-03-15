<?php
namespace Squids\DAO\Connector;


use Squids\SquidsScope;
use Squids\Base\DAO\IConnector;

use Squid\MySql;
use Squid\MySql\IMySqlConnector;


/**
 * @unique
 */
class DBConnector implements IConnector
{
	/** @var MySql */
	private static $mysql = null;
	
	
	private static function mysql()
	{
		if (!self::$mysql)
		{
			self::$mysql = new MySql();
			self::$mysql->config()->addConfig('meta', SquidsScope::config()->DB->getMetadataCallback());
			self::$mysql->config()->addConfig('target', SquidsScope::config()->DB->getMainDBConfig());
		}
		
		return self::$mysql;
	}
	
	
	public function metadata(): IMySqlConnector
	{
		return self::mysql()->getConnector('meta');
	}
	
	public function target(): IMySqlConnector
	{
		return self::mysql()->getConnector('target');
	}
}