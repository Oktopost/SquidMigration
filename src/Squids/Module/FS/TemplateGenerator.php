<?php
namespace Squids\Module\FS;


use Squids\Exceptions\SquidsException;
use Squids\Objects\IAction;


class TemplateGenerator
{
	private function getPath()
	{
		if (strpos(__DIR__, 'phar://') !== 0)
		{
			return (__DIR__ . '/../../../../templates/SimpleAction.template');
		}
		
		return "phar://squid/SimpleAction.template";
	}
	
	
	public function generate(string $dir, IAction $action)
	{
		$id = $action->id();
		$name = $action->name();
		$namespace = explode('\\', $action->fullName())[0];
		$dep = $action->dependencies();
		$hadDep = false;
		
		if (!$dep)
		{
			$printDep = '[]';
		}
		else if (count($dep) === 1)
		{
			$dep = $dep[0];
			$printDep = "['$dep']";
		}
		else
		{
			$printDep = "[\n";
			
			foreach ($dep as $item)
			{
				if ($hadDep)
					$printDep .= ",\n";
				
				$hadDep = true;
				$printDep .=  "\t\t'$item'";
			}
			
			$printDep .= "\n\t]";
		}
		
		$data = file_get_contents($this->getPath());
		
		$data = str_replace('{%name_space%}',	$namespace,	$data);
		$data = str_replace('{%name%}',			$name, 		$data);
		$data = str_replace('{%id%}',			$id,		$data);
		$data = str_replace('{%dep%}',			$printDep,	$data);
		
		$fileName = "$dir/{$action->name()}.php"; 
		
		if (file_put_contents($fileName, $data) === false)
		{
			throw new SquidsException("Failed to create Action file [$fileName] for $action");
		}
	}
}