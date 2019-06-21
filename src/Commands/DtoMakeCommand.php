<?php

namespace Larapie\Generator\Commands;

use Larapie\Generator\Abstracts\ClassGeneratorCommand;
use Larapie\Generator\Events\AttributeGeneratedEvent;
use Larapie\Generator\Events\DtoGeneratedEvent;
use Larapie\Generator\Events\EventGeneratedEvent;
use Larapie\Generator\Events\ServiceGeneratedEvent;
use Larapie\Generator\Managers\GeneratorManager;

class DtoMakeCommand extends ClassGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'larapi:make:dto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new data transfer object';

    /**
     * The name of the generated resource.
     *
     * @var string
     */
    protected $generatorName = 'dto';

    /**
     * The stub name.
     *
     * @var string
     */
    protected $stub = 'dto.stub';

    /**
     * The file path.
     *
     * @var string
     */
    protected $filePath = '/Dtos';

    /**
     * The event that will fire when the file is created.
     *
     * @var string
     */
    protected $event = DtoGeneratedEvent::class;

    protected function stubOptions(): array
    {
        return [
            'NAMESPACE' => $this->getClassNamespace(),
            'CLASS' => $this->getClassName(),
        ];
    }
}
