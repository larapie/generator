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
 * Class FactoryGeneratedEvent
 * @package Larapie\Generator\Events
 */
class FactoryGeneratedEvent extends ResourceGeneratedEvent
{
    public function getModel()
    {
        return $this->getStubOption("model");
    }

    public function getModelNamespace()
    {
        return $this->getStubOption("model_namespace");
    }
}
