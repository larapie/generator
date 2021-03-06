<?php

namespace Larapie\Generator\Commands;

use Larapie\Generator\Abstracts\ClassGeneratorCommand;
use Larapie\Generator\Events\ExceptionGeneratedEvent;

class ExceptionMakeCommand extends ClassGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'larapie:make:exception';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new exception class for the specified module';

    /**
     * The name of the generated resource.
     *
     * @var string
     */
    protected $generatorName = 'exception';

    /**
     * The stub name.
     *
     * @var string
     */
    protected $stub = 'exception.stub';

    /**
     * The file path.
     *
     * @var string
     */
    protected $filePath = '/Exceptions';

    /**
     * The event that will fire when the file is created.
     *
     * @var string
     */
    protected $event = ExceptionGeneratedEvent::class;

    protected function stubOptions(): array
    {
        return [
            'NAMESPACE' => $this->getClassNamespace(),
            'CLASS' => $this->getClassName(),
        ];
    }

    protected function resourcePath(): string
    {
        return config('larapie.resources.exception');
    }

}
