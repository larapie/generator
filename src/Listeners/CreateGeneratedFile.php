<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 10.03.19
 * Time: 20:39
 */

namespace Larapie\Generator\Listeners;


use Larapie\Generator\Contracts\ResourceGenerationContract;
use Larapie\Generator\Generators\FileGenerator;

/**
 * Class CreateGeneratedFile
 * @package Larapie\Generator\Listeners
 */
class CreateGeneratedFile
{
    /**
     * Handle the event.
     *
     * @param  ResourceGenerationContract $event
     * @return void
     */
    public function handle(ResourceGenerationContract $event)
    {
        if (file_exists($event->getFilePath()))
            unlink($event->getFilePath());

        (new FileGenerator(
            $event->getFilePath(),
            $event->getStub()->render()
        ))->generate();
    }
}
