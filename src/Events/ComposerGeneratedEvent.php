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
 * Class ComposerGeneratedEvent
 * @package Larapie\Generator\Events
 */
class ComposerGeneratedEvent extends ResourceGeneratedEvent
{
    public function getAuthorName(){
        return $this->getStubOption("author_name");
    }

    public function getAuthorMail(){
        return $this->getStubOption("author_mail");
    }
}
