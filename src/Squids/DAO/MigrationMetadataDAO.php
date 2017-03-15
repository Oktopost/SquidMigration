<?php
namespace Squids\DAO;


use Squids\Base\DAO\IConnector;
use Squids\Base\DAO\IMigrationMetadataDAO;
use Squids\Objects\MigrationMetadata;

use Squid\MySql\Impl\Connectors\MySqlAutoIncrementConnector;


/**
 * @autoload
 */
class MigrationMetadataDAO implements IMigrationMetadataDAO
{
	const TABLE_NAME	= '_SquidMigration_Metadata_';
	
	
	/** @var IConnector */
	private $connector;
	
	/** @var MySqlAutoIncrementConnector */
	private $objectConnector;
	
	
	public function __construct(IConnector $connector)
	{
		$this->objectConnector = new MySqlAutoIncrementConnector();
		$this->objectConnector
			->setConnector($connector->metadata())
			->setDomain(MigrationMetadata::class)
			->setTable(self::TABLE_NAME)
			->setIdField('ID');
	}


	public function save(MigrationMetadata $m)
	{
		$this->objectConnector->save($m);
	}

	/**
	 * @return MigrationMetadata[]
	 */
	public function loadAll(): array
	{
		$data = $this->connector->metadata()
			->select()
			->from(self::TABLE_NAME)
			->queryAll(true);
		
		return MigrationMetadata::allFromArray($data);
	}
}