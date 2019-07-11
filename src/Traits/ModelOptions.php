<?php


namespace Larapie\Generator\Traits;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

trait ModelOptions
{
    protected function injectModelOptions(array $options)
    {
        return array_merge($options, [
            'MODEL' => $this->getModelName(),
            "LOWER_MODEL" => Str::snake($this->getModelName()),
            'MODEL_NAMESPACE' => $this->getModelBaseNamespace() . '\\' . $this->getModelName()
        ]);
    }

    protected function getModelBaseNamespace()
    {
        return $this->getModule()->getModels()->getNamespace();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function setOptions(): array
    {
        return [
            ['model', null, InputOption::VALUE_OPTIONAL, 'The Model name for the transformer.', null],
        ];
    }

    protected function injectModelOption(): array
    {
        return ['model', null, InputOption::VALUE_OPTIONAL, 'The Model name for the transformer.', null];
    }

    protected function getModelName(): string
    {
        return $this->getOption("model");
    }

    protected function handleModelOption()
    {
        return $this->anticipate('For what model would you like to generate a transformer?', $this->getModule()->getModels()->getClassNames(), $this->getModuleName());
    }

    protected function getMainModelClass()
    {
        return $this->getModuleName();
    }
}
