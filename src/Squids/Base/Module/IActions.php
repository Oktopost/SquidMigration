<?php
namespace Squids\Base\Module;


use Squids\Base\Module\Actions\ITree;
use Squids\Base\Module\Actions\IActionCollection;


interface IActions
{
	public function collection(): IActionCollection;
	public function tree(): ITree;
}