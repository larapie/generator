<?php

namespace Larapie\Generator\Commands;

use Larapie\Generator\Abstracts\FileGeneratorCommand;
use Larapie\Generator\Events\FactoryGeneratedEvent;
use Symfony\Component\Console\Input\InputOption;

class FactoryMakeCommand extends FileGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'larapie:make:factory';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model factory for the specified module.';

    /**
     * The name of the generated resource.
     *
     * @var string
     */
    protected $generatorName = 'factory';

    /**
     * The stub name.
     *
     * @var string
     */
    protected $stub = 'factory.stub';

    /**
     * The event that will fire when the file is created.
     *
     * @var string
     */
    protected $event = FactoryGeneratedEvent::class;

    protected function getClassName(): string
    {
        return $this->getModelName() . 'Factory';
    }

    protected function stubOptions(): array
    {
        return [
            'CLASS' => $this->getClassName(),
            'MODEL' => $this->getModelName(),
            'MODEL_NAMESPACE' => $this->getModule()->getModels()->getNamespace() . '\\' . $this->getModelName(),
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function setOptions(): array
    {
        return [
            ['model', null, InputOption::VALUE_OPTIONAL, 'The Model name for the factory.', null],
        ];
    }

    protected function handleModelOption($shortcut, $type, $question, $default)
    {
        return $this->anticipate('For what model would you like to generate a factory?', $this->getModule()->getModels()->getClassNames());
    }

    protected function getModelName() :string
    {
        return $this->getOption('model');
    }

    protected function getFileName(): string
    {
        return $this->getClassName().'.php';
    }

    protected function resourcePath(): string
    {
        return config('larapie.resources.factories');
    }
}
