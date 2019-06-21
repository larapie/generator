<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 10.03.19
 * Time: 20:15
 */

namespace Larapie\Generator\Events;


use Larapie\Generator\Abstracts\ResourceGeneratedEvent;

/**
 * Class MigrationGeneratedEvent
 * @package Larapie\Generator\Events
 */
class MigrationGeneratedEvent extends ResourceGeneratedEvent
{
    public function getTableName()
    {
        return $this->getStubOption("table");
    }

    public function isMongoMigration(){
        return $this->getStubOption("mongo");
    }
}
