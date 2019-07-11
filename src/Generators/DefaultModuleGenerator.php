<?php
/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 23.03.19
 * Time: 00:51
 */

namespace Larapie\Generator\Generators;


use Illuminate\Support\Str;
use Larapie\Generator\Factories\ModuleFactory;

/**
 * Class DefaultModuleGenerator
 * @package Larapie\Generator\Generators
 */
class DefaultModuleGenerator
{
    /**
     * @var string
     */
    protected $moduleName;

    /**
     * @var ModuleFactory
     */
    protected $factory;

    /**
     * DefaultModuleGenerator constructor.
     * @param $moduleFactory
     */
    public function __construct(string $moduleName)
    {
        $this->moduleName = $moduleName;
        $this->factory = new ModuleFactory($moduleName);
    }

    /**
     *
     */
    public function generate()
    {

        $this->factory->addModel($this->moduleName, false, true);

        $this->factory->addCrudAction('Create' . $this->moduleName . 'Action', $this->moduleName, 'create');
        $this->factory->addCrudAction('Update' . $this->moduleName . 'Action', $this->moduleName, 'update');
        $this->factory->addCrudAction('Delete' . $this->moduleName . 'Action', $this->moduleName, 'delete');
        $this->factory->addCrudAction('Get' . Str::plural($this->moduleName) . 'Action', $this->moduleName, 'index');
        $this->factory->addCrudAction('Find' . $this->moduleName . 'Action', $this->moduleName, 'find');

        $this->factory->addTest($this->moduleName . 'UnitTest', 'unit');

        $this->factory->addEvent($this->moduleName . 'WasCreatedEvent');
        $this->factory->addEvent($this->moduleName . 'WasUpdatedEvent');
        $this->factory->addEvent($this->moduleName . 'WasDeletedEvent');

        $this->factory->addPermission($this->moduleName . 'Permission');

        $this->factory->addPolicy($this->moduleName . 'Policy',$this->moduleName);

        $this->factory->addFactory($this->moduleName);

        $this->factory->addTransformer($this->moduleName . 'Transformer', $this->moduleName);

        $this->factory->addServiceProvider($this->moduleName . 'ServiceProvider');

        $this->factory->addSeeder($this->moduleName . 'Seeder');

        $this->factory->addRoute('v1');

        $this->factory->addComposer();

        $this->factory->build();
    }


}
