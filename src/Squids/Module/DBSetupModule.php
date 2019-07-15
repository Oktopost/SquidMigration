<?php
namespace Squids\Module;


use Squid\MySql;
use Squids\Base\Module\IDBSetup;


class DBSetupModule implements IDBSetup
{
	const CREATE_QUERY = <<<EOT
CREATE DATABASE IF NOT EXISTS `{db}` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `{db}`;

CREATE TABLE IF NOT EXISTS `_SquidMigration_Metadata_` 
(
	`ID`		int(11) NOT NULL AUTO_INCREMENT,
	`ActionID`	char(32) NOT NULL,
	`Name`		varchar(128) NOT NULL,
	`FullName`	varchar(128) NOT NULL,
	`StartDate`	datetime NOT NULL,
	`EndDate`	datetime NOT NULL,
	
	PRIMARY KEY (`ID`),
	UNIQUE KEY `u_ActionID` (`ActionID`),
	UNIQUE KEY `u_FullName` (`FullName`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;
EOT;
	
	private function get(string $message, string $default = ''): string
	{
		echo $message;
		$data = trim(fgets(STDIN));
		return ($data ?: $default);
	}
	
	private function getData()
	{
		$user	= $this->get('Root user [root] : ', 'root');
		$pass	= $this->get('Root password [] : ', '');
		$db		= $this->get('DB Name [squid]  : ', 'squid');
		$host	= $this->get('Host [localhost] : ', 'localhost');
		
		echo "\n";
		echo "Please confirm:\n";
		echo "Host: $host\n";
		echo "DB:   $db\n";
		
		$isCorrect = $this->get('Is correct [Y/n]: ', 'y');
		
		if (strtolower($isCorrect) !== 'y')
		{
			echo "\nAborting...\n\n";
			die;
		}
		
		return [
			'user'	=> $user,
			'pass'	=> $pass,
			'db'	=> $db,
			'host'	=> $host
		];
	}
	
	private function getConnection(array $config): MySql\IMySqlConnector
	{
		unset($config['db']);
		
		$mysql = new MySql();
		$mysql->config()->addConfig($config);
		$conn = $mysql->getConnector();
		
		try
		{
			$res = $conn->select()->columnsExp('1')->queryScalar();
			
			if ((string)$res !== '1')
				throw new \Exception('Failed to test connection');
		}
		catch (\Exception $e)
		{
			echo "\nFailed to connect to database! Validate your configuration.\n";
			echo "Got error: \n\t{$e->getCode()}, {$e->getMessage()}\n\n";
			die;
		}
		
		return $conn;
	}
	
	
	public function run()
	{
		$data = $this->getData();
		$conn = $this->getConnection($data);
		$query = str_replace('{db}', $data['db'], self::CREATE_QUERY);
		
		echo "Executing...\n";
		
		try
		{
			$conn->bulk()->add($query)->executeAll();
		}
		catch (\Exception $e)
		{
			echo "\nError encountered during DB creation: {$e->getMessage()}. " . 
				"Validate Database integrity and try again\n\n";
			die;
		}
		
		echo "\nOperation complete successfully!\n\n";
	}
}