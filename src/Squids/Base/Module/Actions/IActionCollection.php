<?php
namespace Squids\Base\Module\Actions;


use Squids\Base\Module\ILoader;
use Squids\Objects\IAction;


/**
 * @skeleton
 */
interface IActionCollection
{
	public function get($id): IAction;

	/**
	 * @param array $ids
	 * @return IAction[]
	 */
	public function getAll(array $ids): array;
	
	public function getByFullName($name): IAction;
	public function has($id): bool;
	public function hasFullName($name): bool;
	public function add(IAction $action);

	/**
	 * @return IAction[]
	 */
	public function all(): array;
	
	public function load(ILoader $loader);
}