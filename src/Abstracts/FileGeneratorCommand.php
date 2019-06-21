<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 09.03.19
 * Time: 17:15.
 */

namespace Larapie\Generator\Abstracts;


abstract class FileGeneratorCommand extends AbstractGeneratorCommand
{
    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function setArguments(): array
    {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function setOptions() :array
    {
        return [];
    }
}
