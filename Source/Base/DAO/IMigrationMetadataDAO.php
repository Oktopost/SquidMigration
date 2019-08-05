<?php
namespace Squids\Base\DAO;


use Squids\Objects\MigrationMetadata;


/**
 * @skeleton
 */
interface IMigrationMetadataDAO
{
	public function save(MigrationMetadata $m);

	/**
	 * @return MigrationMetadata[]
	 */
	public function loadAll(): array;
}