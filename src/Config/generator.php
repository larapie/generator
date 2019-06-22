<?php

return [
    'stub_path' => env('GENERATOR_STUB_PATH', 'app/Foundation/Stubs'),

    'commands' => [
        'action' => \Larapie\Generator\Commands\ActionMakeCommand::class,
        'attribute' => \Larapie\Generator\Commands\AttributeMakeCommand::class,
        'command' => \Larapie\Generator\Commands\CommandMakeCommand::class,
        'composer' => \Larapie\Generator\Commands\ComposerMakeCommand::class,
        'controller' => \Larapie\Generator\Commands\ControllerMakeCommand::class,
        'dto' => \Larapie\Generator\Commands\DtoMakeCommand::class,
        'event' => \Larapie\Generator\Commands\EventMakeCommand::class,
        'exception' => \Larapie\Generator\Commands\ExceptionMakeCommand::class,
        'factory' => \Larapie\Generator\Commands\FactoryMakeCommand::class,
        'guard' => \Larapie\Generator\Commands\GuardMakeCommand::class,
        'job' => \Larapie\Generator\Commands\JobMakeCommand::class,
        'listener' => \Larapie\Generator\Commands\ListenerMakeCommand::class,
        'middleware' => \Larapie\Generator\Commands\MiddlewareMakeCommand::class,
        'migration' => \Larapie\Generator\Commands\MigrationMakeCommand::class,
        'model' => \Larapie\Generator\Commands\ModelMakeCommand::class,
        'module' => \Larapie\Generator\Commands\ModuleMakeCommand::class,
        'notification' => \Larapie\Generator\Commands\NotificationMakeCommand::class,
        'permission' => \Larapie\Generator\Commands\PermissionMakeCommand::class,
        'policy' => \Larapie\Generator\Commands\PolicyMakeCommand::class,
        'provider' => \Larapie\Generator\Commands\ProviderMakeCommand::class,
        'repository' => \Larapie\Generator\Commands\RepositoryMakeCommand::class,
        'repository_contract' => \Larapie\Generator\Commands\RepositoryContractMakeCommand::class,
        'request' => \Larapie\Generator\Commands\RequestMakeCommand::class,
        'route' => \Larapie\Generator\Commands\RouteMakeCommand::class,
        'rule' => \Larapie\Generator\Commands\RuleMakeCommand::class,
        'seeder' => \Larapie\Generator\Commands\SeederMakeCommand::class,
        'service' => \Larapie\Generator\Commands\ServiceMakeCommand::class,
        'service_contract' => \Larapie\Generator\Commands\ServiceContractMakeCommand::class,
        'test' => \Larapie\Generator\Commands\TestMakeCommand::class,
        'transformer' => \Larapie\Generator\Commands\TransformerMakeCommand::class
    ]
];
