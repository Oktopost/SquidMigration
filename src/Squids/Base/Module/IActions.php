<?php
namespace Squids\Base\Module;


use Squids\Base\Module\Actions\ITree;
use Squids\Base\Module\Actions\IActionCollection;
use Squids\Objects\IAction;


interface IActions
{
	public function collection(): IActionCollection;
	public function tree(): ITree;
	public function generate(string $name);
}