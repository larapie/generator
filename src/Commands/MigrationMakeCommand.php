<?php

namespace Larapie\Generator\Commands;

use Larapie\Generator\Abstracts\ClassGeneratorCommand;
use Larapie\Generator\Events\MigrationGeneratedEvent;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class MigrationMakeCommand extends ClassGeneratorCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'larapie:make:migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new migration for the specified module.';

    /**
     * The name of the generated resource.
     *
     * @var string
     */
    protected $generatorName = 'migration';

    /**
     * The file path.
     *
     * @var string
     */
    protected $filePath = '/Database/Migrations';

    /**
     * The event that will fire when the file is created.
     *
     * @var string
     */
    protected $event = MigrationGeneratedEvent::class;

    protected function stubOptions(): array
    {
        return [
            'CLASS' => $this->getClassName(),
            'NAMESPACE' => $this->getClassNamespace(),
            "TABLE" => $this->getTableName(),
            "MONGO" => $this->isMongoMigration()
        ];
    }

    protected function getTableName(): string
    {
        return $this->getOption('table');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function setOptions() :array
    {
        return [
            ['mongo', null, InputOption::VALUE_OPTIONAL, 'Mongo migration.', null],
            ['table', null, InputOption::VALUE_OPTIONAL, 'Name of the table/collection.', null],
        ];
    }

    protected function handleTableOption(){
        return $this->ask('What is the name of the table/collection?', strtolower(Str::plural($this->getModuleName())));
    }

    protected function handleMongoOption(){
        return $this->confirm('Is this migration for a mongodb database?', false);
    }

    protected function isMongoMigration(): bool
    {
        return $this->getOption('mongo');
    }

    /**
     * @return string
     */
    protected function stubName(): string
    {
        if ($this->isMongoMigration()) {
            return 'migration-mongo.stub';
        }

        return 'migration.stub';
    }

    /**
     * @return mixed
     */
    protected function getDestinationFilePath() :string
    {
        return $this->getModule()->getPath() . $this->filePath . '/' . $this->getDestinationFileName() . '.php';
    }

    /**
     * @return string
     */
    private function getDestinationFileName()
    {
        return date('Y_m_d_His_') . Str::snake($this->getClassName(),'_');
    }

    protected function resourcePath(): string
    {
        return config('larapie.resources.migrations');
    }
}
