<?php

namespace Larapie\Generator\Commands;

use Larapie\Generator\Abstracts\ClassGeneratorCommand;
use Larapie\Generator\Events\NotificationGeneratedEvent;

final class NotificationMakeCommand extends ClassGeneratorCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'larapie:make:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new notification class for the specified module.';

    /**
     * The name of the generated resource.
     *
     * @var string
     */
    protected $generatorName = 'notification';

    /**
     * The stub name.
     *
     * @var string
     */
    protected $stub = 'notification.stub';

    /**
     * The file path.
     *
     * @var string
     */
    protected $filePath = '/Notifications';

    /**
     * The event that will fire when the file is created.
     *
     * @var string
     */
    protected $event = NotificationGeneratedEvent::class;


    protected function stubOptions(): array
    {
        return [
            'NAMESPACE' => $this->getClassNamespace(),
            'CLASS' => $this->getClassName(),
        ];
    }

    protected function resourcePath(): string
    {
        return config('larapie.resources.notifications');
    }
}
