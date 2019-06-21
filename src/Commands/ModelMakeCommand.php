<?php

namespace Larapie\Generator\Commands;

use Larapie\Generator\Abstracts\AbstractGeneratorCommand;
use Larapie\Generator\Abstracts\ClassGeneratorCommand;
use Larapie\Generator\Events\ModelGeneratedEvent;
use Larapie\Generator\Managers\GeneratorManager;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class ModelMakeCommand extends ClassGeneratorCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'larapie:make:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model for the specified module.';

    /**
     * The name of the generated resource.
     *
     * @var string
     */
    protected $generatorName = 'model';

    /**
     * The file path.
     *
     * @var string
     */
    protected $filePath = '/Entities';

    /**
     * The event that will fire when the file is created.
     *
     * @var string
     */
    protected $event = ModelGeneratedEvent::class;

    protected function stubOptions(): array
    {
        return [
            'NAMESPACE' => $this->getClassNamespace(),
            'CLASS' => $this->getClassName(),
            'MONGO' => $this->isMongoModel(),
            'MIGRATION' => $this->needsMigration()
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
            ['mongo', null, InputOption::VALUE_OPTIONAL, 'Mongo model.', false],
            ['migration', null, InputOption::VALUE_OPTIONAL, 'Create migration for the model.', true],
        ];
    }

    protected function handleMongoOption($shortcut, $type, $question, $default)
    {
        return $this->confirm('Is this model for a mongodb database?', $default);
    }

    protected function isMongoModel(): bool
    {
        return $this->getOption('mongo');
    }

    protected function handleMigrationOption($shortcut, $type, $question, $default)
    {
        return $this->confirm('Do you want to create a migration for this model?', $default);
    }

    protected function needsMigration(): bool
    {
        return $this->getOption('migration');
    }

    public function afterGeneration(): void
    {
        if ($this->needsMigration()) {
            if ($this->isMongoModel()) {
                GeneratorManager::module($this->getModuleName(), $this->isOverwriteable())
                    ->createMigration(
                        "Create" . ucfirst($this->getClassName()) . "Collection",
                        strtolower(Str::snake(Str::plural($this->getClassName()),'_')),
                        true);
            } else {
                GeneratorManager::module($this->getModuleName(), $this->isOverwriteable())
                    ->createMigration(
                        "Create" . ucfirst($this->getClassName() . "Table"),
                        strtolower(Str::snake(Str::plural($this->getClassName()),'_')),
                        false);
            }
        }
        GeneratorManager::module($this->getModuleName(), $this->isOverwriteable())
            ->createAttribute($this->getClassName() . "Attributes");
    }

    /**
     * @return string
     */
    protected function stubName(): string
    {
        if ($this->isMongoModel()) {
            return 'model-mongo.stub';
        }

        return 'model.stub';
    }
}
