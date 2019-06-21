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
 * Class JobGeneratedEvent
 * @package Larapie\Generator\Events
 */
class JobGeneratedEvent extends ResourceGeneratedEvent
{
    public function isSynchronous(): bool
    {
        return $this->getStubOption('sync');
    }
}
