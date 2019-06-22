<?php

namespace Larapie\Generator\Commands;

use Larapie\Generator\Abstracts\AbstractGeneratorCommand;
use Larapie\Generator\Abstracts\ClassGeneratorCommand;
use Larapie\Generator\Events\RuleGeneratedEvent;

class RuleMakeCommand extends ClassGeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'larapie:make:rule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new validation rule for the specified module.';

    /**
     * The name of the generated resource.
     *
     * @var string
     */
    protected $generatorName = 'rule';

    /**
     * The stub name.
     *
     * @var string
     */
    protected $stub = 'rule.stub';

    /**
     * The file path.
     *
     * @var string
     */
    protected $filePath = '/Rules';

    /**
     * The event that will fire when the file is created.
     *
     * @var string
     */
    protected $event = RuleGeneratedEvent::class;

    protected function stubOptions(): array
    {
        return [
            'NAMESPACE' => $this->getClassNamespace(),
            'CLASS' => $this->getClassName(),
        ];
    }

    protected function resourcePath(): string
    {
        return config('larapie.resources.rules');
    }
}
