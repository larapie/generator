<?php

namespace Larapie\Generator\Commands;

use Larapie\Generator\Abstracts\ClassGeneratorCommand;
use Larapie\Generator\Events\MiddlewareGeneratedEvent;

class MiddlewareMakeCommand extends ClassGeneratorCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'larapie:make:middleware';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new middleware class for the specified module.';

    /**
     * The name of the generated resource.
     *
     * @var string
     */
    protected $generatorName = 'middleware';

    /**
     * The stub name.
     *
     * @var string
     */
    protected $stub = 'middleware.stub';

    /**
     * The file path.
     *
     * @var string
     */
    protected $filePath = '/Http/Middleware';

    /**
     * The event that will fire when the file is created.
     *
     * @var string
     */
    protected $event = MiddlewareGeneratedEvent::class;


    protected function stubOptions(): array
    {
        return [
            'CLASS' => $this->getClassName(),
            'NAMESPACE' => $this->getClassNamespace(),
        ];
    }

    protected function resourcePath(): string
    {
        return config('larapie.resources.middleware');
    }

}
