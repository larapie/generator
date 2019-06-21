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
 * Class RouteGeneratedEvent
 * @package Larapie\Generator\Events
 */
class RouteGeneratedEvent extends ResourceGeneratedEvent
{
    public function getVersion(){
        return $this->getStubOption("version");
    }
}
