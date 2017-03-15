<?php
namespace Squids\Base\Module;
/** @var \Skeleton\Base\IBoneConstructor $this */


use Squids\Module\Actions\Tree;
use Squids\Module\ActionsModule;
use Squids\Module\ActionsFSModule;
use Squids\Module\MigrationStateModule;
use Squids\Module\Actions\ActionCollection;

$this->set(IActions::class,			ActionsModule::class);
$this->set(IActionsFS::class,		ActionsFSModule::class);
$this->set(IMigrationState::class,	MigrationStateModule::class);


use Squids\Base\Module\Actions\ITree;
use Squids\Base\Module\Actions\IActionCollection;

$this->set(ITree::class,				Tree::class);
$this->set(IActionCollection::class,	ActionCollection::class);