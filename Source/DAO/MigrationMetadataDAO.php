<?php
namespace Squids\DAO;


use Squid\MySql\Impl\Connectors\Objects\Generic\GenericIdConnector;
use Squids\Base\DAO\IConnector;
use Squids\Base\DAO\IMigrationMetadataDAO;
use Squids\Objects\MigrationMetadata;


/**
 * @autoload
 */
class MigrationMetadataDAO implements IMigrationMetadataDAO
{
	const TABLE_NAME	= '_SquidMigration_Metadata_';
	
	
	/** @var IConnector */
	private $connector;
	
	/** @var GenericIdConnector */
	private $objectConnector;
	
	
	public function __construct(IConnector $connector)
	{
		$this->connector = $connector;
		$this->objectConnector = new GenericIdConnector();
		$this->objectConnector
			->setConnector($connector->metadata())
			->setObjectMap(MigrationMetadata::class)
			->setTable(self::TABLE_NAME)
			->setAutoIncrementId('ID');
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