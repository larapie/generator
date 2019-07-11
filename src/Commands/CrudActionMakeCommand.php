<?php

namespace Larapie\Generator\Commands;

use Larapie\Generator\Abstracts\ClassGeneratorCommand;
use Larapie\Generator\Events\ActionGeneratedEvent;
use Larapie\Generator\Traits\ModelOptions;
use Symfony\Component\Console\Input\InputOption;

class CrudActionMakeCommand extends ClassGeneratorCommand
{
    use ModelOptions;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'larapie:make:action-crud';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new crud action';

    /**
     * The name of the generated resource.
     *
     * @var string
     */
    protected $generatorName = 'action';


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
        return $this->injectModelOptions([
            'NAMESPACE' => $this->getClassNamespace(),
            'CLASS' => $this->getClassName(),
            'TRANSFORMER' => $transformer = $this->getModelName().'Transformer',
            'TRANSFORMER_NAMESPACE' => $this->getModule()->getTransformers()->getFilteredNamespace(),
            'EVENT_NAMESPACE' => $this->getModule()->getEvents()->getFilteredNamespace()
        ]);
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function setOptions(): array
    {
        return [
            $this->injectModelOption(),
            ['crud', null, InputOption::VALUE_REQUIRED, 'The type of crud action.', null]
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

    protected function getCrudName(): string
    {
        return $this->getOption("crud");
    }

    protected function handleCrudOption()
    {
        return $this->anticipate('What type of crud action is this?', ['create', 'delete', 'update', 'find', 'index'], 'create');
    }

    function stubName()
    {
        return 'action-' . strtolower($this->getCrudName()) . '.stub';
    }
}
