<?php
namespace Squids\Base\DAO;


use Squid\MySql\IMySqlConnector;


/**
 * @skeleton
 */
interface IConnector
{
	public function metadata(): IMySqlConnector;
	public function target(): IMySqlConnector;
}