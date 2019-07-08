<?php

namespace Larapie\Generator\Commands;

use Larapie\Generator\Abstracts\ClassGeneratorCommand;
use Larapie\Generator\Events\ActionGeneratedEvent;

class ActionMakeCommand extends ClassGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'larapie:make:action';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new action';

    /**
     * The name of the generated resource.
     *
     * @var string
     */
    protected $generatorName = 'action';

    /**
     * The stub name.
     *
     * @var string
     */
    protected $stub = 'action.stub';


    /**
     * The file path.
     *
     * @var string
     */
    protected $filePath = '/Actions';

    /**
     * The event that will fire when the file is created.
     *
     * @var string
     */
    protected $event = ActionGeneratedEvent::class;

    protected function stubOptions(): array
    {
        return [
            'NAMESPACE' => $this->getClassNamespace(),
            'CLASS' => $this->getClassName(),
        ];
    }

    protected function afterGeneration(): void
    {
        $this->info("don't forget to implement this attribute on the model");
    }

    protected function resourcePath(): string
    {
        return config('larapie.resources.actions');
    }
}
