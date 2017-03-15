<?php
namespace Squids\Base\DAO;
/** @var \Skeleton\Base\IBoneConstructor $this */


$this->set(IConnector::class, \Squids\DAO\Connector\DBConnector::class);


use Squids\DAO\MigratingDAO;
use Squids\DAO\MigrationMetadataDAO;

$this->set(IMigratingDAO::class,			MigratingDAO::class);
$this->set(IMigrationMetadataDAO::class,	MigrationMetadataDAO::class);