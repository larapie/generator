<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 09.03.19
 * Time: 18:23.
 */

namespace Larapie\Generator;

use Larapie\Generator\Console\PublishStubsCommand;
use Larapie\Generator\Contracts\ResourceGenerationContract;
use Larapie\Generator\Listeners\CreateGeneratedFile;
use Illuminate\Support\ServiceProvider;

class LarapieGeneratorServiceProvider extends ServiceProvider
{
    protected $commands = [
        PublishStubsCommand::class
    ];

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishConfig();
        $this->registerResourceMakeCommands();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        \Event::listen(ResourceGenerationContract::class, CreateGeneratedFile::class);
        $this->mergeConfigFrom(__DIR__ . '/Config/generator.php', 'generator');
        $this->commands($this->commands);
    }

    protected function publishConfig()
    {
        $this->publishes([
            __DIR__.'/Config/generator.php' => config_path('generator.php'),
        ]);
    }

    public function registerResourceMakeCommands(){
        $this->commands([
            config('generator.commands.action'),
            config('generator.commands.attribute'),
            config('generator.commands.command'),
            config('generator.commands.composer'),
            config('generator.commands.controller'),
            config('generator.commands.dto'),
            config('generator.commands.event'),
            config('generator.commands.exception'),
            config('generator.commands.factory'),
            config('generator.commands.guard'),
            config('generator.commands.job'),
            config('generator.commands.listener'),
            config('generator.commands.middleware'),
            config('generator.commands.migration'),
            config('generator.commands.model'),
            config('generator.commands.module'),
            config('generator.commands.notification'),
            config('generator.commands.permission'),
            config('generator.commands.policy'),
            config('generator.commands.provider'),
            config('generator.commands.repository'),
            config('generator.commands.repository_contract'),
            config('generator.commands.request'),
            config('generator.commands.route'),
            config('generator.commands.rule'),
            config('generator.commands.seeder'),
            config('generator.commands.service'),
            config('generator.commands.service_contract'),
            config('generator.commands.test'),
            config('generator.commands.transformer')
        ]);
    }
}
