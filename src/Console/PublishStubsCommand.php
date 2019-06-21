<?php


namespace Larapie\Generator\Console;


use Illuminate\Console\Command;

class PublishStubsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'larapie:publish:stubs {--overwrite}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will move all the stubs from the package to the location specified in the config';


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $fileSystem = new \Illuminate\Filesystem\Filesystem();

        $stubs = $fileSystem->allFiles(dirname(__DIR__, 1) . '/Stubs');
        $stubPath = base_path(config('generator.stub_path'));
        if(!$fileSystem->exists($stubPath)){
            $fileSystem->makeDirectory($stubPath);
        }

        foreach ($stubs as $stub) {
            $target = $stubPath . '/' . $stub->getFilename();
            if (!$fileSystem->exists($target) || $this->option('overwrite')) {
                $fileSystem->copy($stub->getRealPath(), $target);
            }
        }
    }
}
