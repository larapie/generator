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
 * Class ModelGeneratedEvent
 * @package Larapie\Generator\Events
 */
class ModelGeneratedEvent extends ResourceGeneratedEvent
{
    public function isMongoModel(){
        return $this->getStub()->getOptions()['MONGO'];
    }

    public function includesMigration(){
        return $this->getStub()->getOptions()['MIGRATION'];
    }
}
