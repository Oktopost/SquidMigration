<?php
namespace Squids\Module\Config;


use Squids\Config\Main;
use Squids\Exceptions\SquidsException;


class ConfigLoader
{
	const SEARCH_FOR = [
		'squids.ini',
		'config/squids.ini',
		'scripts/squids.ini',
		'squids/squids.ini',
		'squids/config.ini',
		'squids/config/config.ini',
		'squids/config/squids.ini'
	];
	
	
	private function findConfigFile(): string
	{
		$dir = getcwd();
		
		foreach (self::SEARCH_FOR as $item)
		{
			$fullPath = $dir . '/' . $item;
			var_dump($fullPath);
			if (file_exists($fullPath))
			{
				return $fullPath;
			}
		}
		
		return '';
	}
	
	
	public function get(): Main
	{
		$main = new Main();
		$fullPath = $this->findConfigFile();
		
		if (!$fullPath)
			throw new SquidsException('Config file not found');
		
		$data = parse_ini_file($fullPath, true);
		
		if ($data === false || 
			!isset($data['main']) || 
			!isset($data['main']['dir.main']) || 
			!isset($data['main']['config.db-file']))
		{
			throw new SquidsException('Failed to parse config file: ' . $fullPath);
		}
		
		$main->Paths->DBConfigFile = getcwd() . '/' . $data['main']['config.db-file'];
		$main->Paths->MigrationsDir = getcwd() . '/' . $data['main']['dir.main'];
		
		if (!file_exists($main->Paths->DBConfigFile))
			throw new SquidsException('Failed to find file: ' . $main->Paths->DBConfigFile);
		
		$data = parse_ini_file($main->Paths->DBConfigFile,  true);
		
		if ($data === false || !isset($data['metadata']) || !isset($data['main']))
			throw new SquidsException('Failed to parse config file: ' . $main->Paths->DBConfigFile);
		
		$main->DB->setMetadataDB($data['metadata']);
		$main->DB->setMainDB($data['main']);
		
		return $main;
	}
}