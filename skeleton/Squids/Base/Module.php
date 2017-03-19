<?php
namespace Squids\Base\Module;
/** @var \Skeleton\Base\IBoneConstructor $this */


use Squids\Module\ReportModule;
use Squids\Module\DBSetupModule;
use Squids\Module\CLIController;
use Squids\Module\ActionsModule;
use Squids\Module\ActionsFSModule;
use Squids\Module\MigrationModule;
use Squids\Module\MigrationStateModule;

$this->set(IDBSetup::class,			DBSetupModule::class);
$this->set(IActions::class,			ActionsModule::class);
$this->set(IReporter::class,		ReportModule::class);
$this->set(IActionsFS::class,		ActionsFSModule::class);
$this->set(IMigration::class,		MigrationModule::class);
$this->set(ICLIController::class,	CLIController::class);
$this->set(IMigrationState::class,	MigrationStateModule::class);


use Squids\Base\Module\Actions\ITree;
use Squids\Base\Module\Actions\IActionCollection;
use Squids\Module\Actions\Tree;
use Squids\Module\Actions\ActionCollection;

$this->set(ITree::class,				Tree::class);
$this->set(IActionCollection::class,	ActionCollection::class);


use Squids\Base\Module\Config\ISetup;
use Squids\Module\Config\Setup;

$this->set(ISetup::class, Setup::class);