<?php

namespace Larapie\Generator\Commands;

use Foundation\Core\Larapi;
use Larapie\Generator\Abstracts\AbstractGeneratorCommand;
use Larapie\Generator\Abstracts\ClassGeneratorCommand;
use Larapie\Generator\Events\TransformerGeneratedEvent;
use Symfony\Component\Console\Input\InputOption;

class TransformerMakeCommand extends ClassGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'larapie:make:transformer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new transformer class for the specified module.';

    /**
     * The name of the generated resource.
     *
     * @var string
     */
    protected $generatorName = 'transformer';

    /**
     * The stub name.
     *
     * @var string
     */
    protected $stub = 'transformer.stub';

    /**
     * The file path.
     *
     * @var string
     */
    protected $filePath = '/Transformers';

    /**
     * The event that will fire when the file is created.
     *
     * @var string
     */
    protected $event = TransformerGeneratedEvent::class;

    protected function stubOptions(): array
    {
        return [
            'CLASS' => $this->getClassName(),
            'NAMESPACE' => $this->getClassNamespace(),
            'MODEL' => $this->getModelName(),
            "LOWER_MODEL" => strtolower($this->getModelName()),
            'MODEL_NAMESPACE' => $this->getModule()->getModels()->getNamespace() . '\\' . $this->getModelName(),
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function setOptions() :array
    {
        return [
            ['model', null, InputOption::VALUE_OPTIONAL, 'The Model name for the transformer.', null],
        ];
    }

    protected function getModelName(): string
    {
        return $this->getOption("model");
    }

    protected function handleModelOption(){
        return $this->anticipate('For what model would you like to generate a transformer?', $this->getModule()->getModels()->getClassNames(), $this->getModuleName());
    }

    protected function resourcePath(): string
    {
        return config('larapie.resources.transformers');
    }
}
