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
 * Class ListenerGeneratedEvent
 * @package Larapie\Generator\Events
 */
class ListenerGeneratedEvent extends ResourceGeneratedEvent
{
    public function getEvent(){
        return $this->getStubOption("event");
    }

    public function getEventNamespace(){
        return $this->getStubOption("event_namespace");
    }

    public function isQueued(){
        return $this->getStubOption("queued");
    }
}
