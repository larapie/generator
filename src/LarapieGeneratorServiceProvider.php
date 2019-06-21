<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 09.03.19
 * Time: 18:23.
 */

namespace Larapie\Generator;

use Larapie\Generator\Commands\AttributeMakeCommand;
use Larapie\Generator\Commands\CommandMakeCommand;
use Larapie\Generator\Commands\ComposerMakeCommand;
use Larapie\Generator\Commands\ControllerMakeCommand;
use Larapie\Generator\Commands\DtoMakeCommand;
use Larapie\Generator\Commands\EventMakeCommand;
use Larapie\Generator\Commands\ExceptionMakeCommand;
use Larapie\Generator\Commands\FactoryMakeCommand;
use Larapie\Generator\Commands\GuardMakeCommand;
use Larapie\Generator\Commands\JobMakeCommand;
use Larapie\Generator\Commands\ListenerMakeCommand;
use Larapie\Generator\Commands\MiddlewareMakeCommand;
use Larapie\Generator\Commands\MigrationMakeCommand;
use Larapie\Generator\Commands\ModelMakeCommand;
use Larapie\Generator\Commands\ModuleMakeCommand;
use Larapie\Generator\Commands\NotificationMakeCommand;
use Larapie\Generator\Commands\PermissionMakeCommand;
use Larapie\Generator\Commands\PolicyMakeCommand;
use Larapie\Generator\Commands\ProviderMakeCommand;
use Larapie\Generator\Commands\RepositoryContractMakeCommand;
use Larapie\Generator\Commands\RepositoryMakeCommand;
use Larapie\Generator\Commands\RequestMakeCommand;
use Larapie\Generator\Commands\RouteMakeCommand;
use Larapie\Generator\Commands\RuleMakeCommand;
use Larapie\Generator\Commands\SeederMakeCommand;
use Larapie\Generator\Commands\ServiceContractMakeCommand;
use Larapie\Generator\Commands\ServiceMakeCommand;
use Larapie\Generator\Commands\TestMakeCommand;
use Larapie\Generator\Commands\TransformerMakeCommand;
use Larapie\Generator\Console\PublishStubsCommand;
use Larapie\Generator\Contracts\ResourceGenerationContract;
use Larapie\Generator\Listeners\CreateGeneratedFile;
use Illuminate\Support\ServiceProvider;

class LarapieGeneratorServiceProvider extends ServiceProvider
{
    protected $commands = [
        FactoryMakeCommand::class,
        CommandMakeCommand::class,
        ControllerMakeCommand::class,
        EventMakeCommand::class,
        JobMakeCommand::class,
        ListenerMakeCommand::class,
        MiddlewareMakeCommand::class,
        MigrationMakeCommand::class,
        ProviderMakeCommand::class,
        NotificationMakeCommand::class,
        ModelMakeCommand::class,
        PolicyMakeCommand::class,
        TestMakeCommand::class,
        RuleMakeCommand::class,
        TransformerMakeCommand::class,
        RequestMakeCommand::class,
        SeederMakeCommand::class,
        RuleMakeCommand::class,
        ComposerMakeCommand::class,
        RouteMakeCommand::class,
        ServiceMakeCommand::class,
        ServiceContractMakeCommand::class,
        ModuleMakeCommand::class,
        ExceptionMakeCommand::class,
        PermissionMakeCommand::class,
        AttributeMakeCommand::class,
        DtoMakeCommand::class,
        GuardMakeCommand::class,
        RepositoryMakeCommand::class,
        RepositoryContractMakeCommand::class,
        PublishStubsCommand::class
    ];

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        \Event::listen(ResourceGenerationContract::class, CreateGeneratedFile::class);
        $this->mergeConfigFrom(__DIR__ . '/Config/generator.php', 'generator');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }
}
