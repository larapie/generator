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
 * Class TestGeneratedEvent
 * @package Larapie\Generator\Events
 */
class TestGeneratedEvent extends ResourceGeneratedEvent
{
    public function getType(){
        return $this->getStubOption("type");
    }
}
