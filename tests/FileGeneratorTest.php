<?php

namespace Larapie\Tests;

use Larapie\Core\LarapieServiceProvider;
use Larapie\Core\Support\Facades\Larapie;
use Larapie\Core\Traits\DispatchedEvents;
use Larapie\Generator\Contracts\ResourceGenerationContract;
use Larapie\Generator\Events\ActionGeneratedEvent;
use Larapie\Generator\Events\AttributeGeneratedEvent;
use Larapie\Generator\Events\CommandGeneratedEvent;
use Larapie\Generator\Events\ComposerGeneratedEvent;
use Larapie\Generator\Events\ControllerGeneratedEvent;
use Larapie\Generator\Events\DtoGeneratedEvent;
use Larapie\Generator\Events\FactoryGeneratedEvent;
use Larapie\Generator\Events\JobGeneratedEvent;
use Larapie\Generator\Events\ListenerGeneratedEvent;
use Larapie\Generator\Events\MiddlewareGeneratedEvent;
use Larapie\Generator\Events\MigrationGeneratedEvent;
use Larapie\Generator\Events\ModelGeneratedEvent;
use Larapie\Generator\Events\NotificationGeneratedEvent;
use Larapie\Generator\Events\PermissionGeneratedEvent;
use Larapie\Generator\Events\PolicyGeneratedEvent;
use Larapie\Generator\Events\ProviderGeneratedEvent;
use Larapie\Generator\Events\RequestGeneratedEvent;
use Larapie\Generator\Events\RouteGeneratedEvent;
use Larapie\Generator\Events\RuleGeneratedEvent;
use Larapie\Generator\Events\SeederGeneratedEvent;
use Larapie\Generator\Events\ServiceGeneratedEvent;
use Larapie\Generator\Events\TestGeneratedEvent;
use Larapie\Generator\Events\TransformerGeneratedEvent;
use Larapie\Generator\LarapieGeneratorServiceProvider;
use Larapie\Generator\Managers\GeneratorManager;
use Illuminate\Support\Str;
use Orchestra\Testbench\TestCase;

/**
 * Created by PhpStorm.
 * User: arthur
 * Date: 10.03.19
 * Time: 18:35
 */
class FileGeneratorTest extends TestCase
{
    use DispatchedEvents;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->register(LarapieServiceProvider::class);
        $this->app->register(LarapieGeneratorServiceProvider::class);

        /* Do not remove this line. It prevents the listener that generates the files from executing */
        $this->listenForEvents();
    }


    protected function getEnvironmentSetUp($app)
    {
        $app->setBasePath(dirname(__DIR__, 1));
    }

    protected function getModuleGenerator(string $moduleName): GeneratorManager
    {
        return GeneratorManager::module($moduleName, true);
    }

    public function testCreateSqlMigration()
    {
        $module = 'User';
        $class = "CreateUserTable";
        $table = "users";
        $mongo = false;
        $this->getModuleGenerator($module)->createMigration($class, $table, $mongo);

        $stub = "migration.stub";
        $table = "users";

        /* @var MigrationGeneratedEvent $event */
        $event = $this->getDispatchedEvents(MigrationGeneratedEvent::class)->first();
        $this->assertNotNull($event);
        $this->assertEquals($module, $event->getModuleName());
        $this->assertEquals($stub, $event->getStub()->getName());
        $this->assertEquals($class, $event->getClassName());
        $this->assertEquals($table, $event->getTableName());
        $this->assertEquals($mongo, $event->isMongoMigration());
    }

    public function testCreateMongoMigration()
    {
        $module = 'User';
        $class = "CreateUserTable";
        $table = "users";
        $mongo = true;
        $this->getModuleGenerator($module)->createMigration($class, $table, $mongo);

        $stub = "migration-mongo.stub";
        $table = "users";

        /* @var MigrationGeneratedEvent $event */
        $event = $this->getDispatchedEvents(MigrationGeneratedEvent::class)->first();
        $this->assertNotNull($event);
        $this->assertEquals($module, $event->getModuleName());
        $this->assertEquals($stub, $event->getStub()->getName());
        $this->assertEquals($class, $event->getClassName());
        $this->assertEquals($table, $event->getTableName());
        $this->assertEquals($mongo, $event->isMongoMigration());
    }

    public function testCreateFactory()
    {
        $module = "User";
        $model = $module;
        $class = $model . "Factory";
        $this->getModuleGenerator($module)->createFactory($module);

        $path = Larapie::getModule($module)->getFactories()->getPath() . "/$class.php";
        $stub = "factory.stub";
        $modelNamespace = Larapie::getModule($module)->getModels()->getNamespace() . '\\' . Str::studly($model);

        /* @var FactoryGeneratedEvent $event */
        $event = $this->getDispatchedEvents(FactoryGeneratedEvent::class)->first();
        $this->assertFileBasics(
            $event,
            $module,
            $stub,
            $path);
        $this->assertEquals($class, $event->getClassName());
        $this->assertEquals($model, $event->getModel());
        $this->assertEquals($modelNamespace, $event->getModelNamespace());

    }

    public function testCreateController()
    {
        $module = "User";
        $class = "UserController";
        $this->getModuleGenerator($module)->createController($class);

        $path = Larapie::getModule($module)->getControllers()->getPath() . "/$class.php";
        $stub = "controller.stub";
        $namespace = Larapie::getModule($module)->getControllers()->getNamespace();

        /* @var ControllerGeneratedEvent $event */
        $event = $this->getDispatchedEvents(ControllerGeneratedEvent::class)->first();
        $this->assertClassBasics(
            $event,
            $module,
            $stub,
            $class,
            $namespace,
            $path);
    }

    public function testCreateAttribute()
    {
        $module = "User";
        $class = "UserAttribute";
        $this->getModuleGenerator($module)->createAttribute($class);

        $path = Larapie::getModule($module)->getAttributes()->getPath() . "/$class.php";
        $stub = "attribute.stub";
        $namespace = Larapie::getModule($module)->getAttributes()->getNamespace();

        /* @var AttributeGeneratedEvent $event */
        $event = $this->getDispatchedEvents(AttributeGeneratedEvent::class)->first();
        $this->assertClassBasics(
            $event,
            $module,
            $stub,
            $class,
            $namespace,
            $path);
    }

    public function testCreateAction()
    {
        $module = "User";
        $class = "UserAction";
        $this->getModuleGenerator($module)->createAction($class);

        $path = Larapie::getModule($module)->getActions()->getPath() . "/$class.php";
        $stub = "action.stub";
        $namespace = Larapie::getModule($module)->getActions()->getNamespace();

        /* @var ActionGeneratedEvent $event */
        $event = $this->getDispatchedEvents(ActionGeneratedEvent::class)->first();
        $this->assertClassBasics(
            $event,
            $module,
            $stub,
            $class,
            $namespace,
            $path);
    }

    public function testCreateCrudAction()
    {
        $module = "User";
        $class = "UserAction";
        $this->getModuleGenerator($module)->createCrudAction($class, $module, 'create');

        $path = Larapie::getModule($module)->getActions()->getPath() . "/$class.php";
        $stub = "action-create.stub";
        $namespace = Larapie::getModule($module)->getActions()->getNamespace();

        /* @var ActionGeneratedEvent $event */
        $event = $this->getDispatchedEvents(ActionGeneratedEvent::class)->first();
        $this->assertClassBasics(
            $event,
            $module,
            $stub,
            $class,
            $namespace,
            $path);
    }

    public function testCreateListener()
    {
        $module = "User";
        $class = "SendWelcomeMail";
        $eventClass = "UserRegisteredEvent";
        $queued = false;
        $this->getModuleGenerator($module)->createListener($class, $eventClass, $queued);

        $path = Larapie::getModule($module)->getListeners()->getPath() . '/SendWelcomeMail.php';
        $stub = "listener.stub";
        $namespace = Larapie::getModule($module)->getListeners()->getNamespace();
        $eventNamespace = Larapie::getModule($module)->getEvents()->getNamespace() . "\\" . $eventClass;

        /* @var ListenerGeneratedEvent $event */
        $event = $this->getDispatchedEvents(ListenerGeneratedEvent::class)->first();
        $this->assertClassBasics(
            $event,
            $module,
            $stub,
            $class,
            $namespace,
            $path);
        $this->assertEquals($queued, $event->isQueued());
        $this->assertEquals($eventClass, $event->getEvent());
        $this->assertEquals($eventNamespace, $event->getEventNamespace());
    }

    public function testCreateQueuedListener()
    {
        $module = "User";
        $class = "SendWelcomeMail";
        $eventClass = "UserRegisteredEvent";
        $queued = true;
        $this->getModuleGenerator($module)->createListener($class, $eventClass, $queued);

        $path = Larapie::getModule($module)->getListeners()->getPath() . '/SendWelcomeMail.php';
        $stub = "listener-queued.stub";
        $namespace = Larapie::getModule($module)->getListeners()->getNamespace();
        $eventNamespace = Larapie::getModule($module)->getEvents()->getNamespace() . "\\" . $eventClass;

        /* @var ListenerGeneratedEvent $event */
        $event = $this->getDispatchedEvents(ListenerGeneratedEvent::class)->first();
        $this->assertClassBasics(
            $event,
            $module,
            $stub,
            $class,
            $namespace,
            $path);
        $this->assertEquals($queued, $event->isQueued());
        $this->assertEquals($eventClass, $event->getEvent());
        $this->assertEquals($eventNamespace, $event->getEventNamespace());
    }

    public function testCreateJob()
    {
        $module = "User";
        $class = "RandomUserJob";
        $synchronous = false;

        $this->getModuleGenerator($module)->createJob($class, $synchronous);

        $path = Larapie::getModule($module)->getJobs()->getPath() . "/$class.php";
        $stub = "job-queued.stub";
        $namespace = Larapie::getModule($module)->getJobs()->getNamespace();

        /* @var JobGeneratedEvent $event */
        $event = $this->getDispatchedEvents(JobGeneratedEvent::class)->first();
        $this->assertClassBasics(
            $event,
            $module,
            $stub,
            $class,
            $namespace,
            $path);
        $this->assertEquals($synchronous, $event->isSynchronous());
    }

    public function testCreateSynchronousJob()
    {
        $module = "User";
        $class = "RandomUserJob";
        $synchronous = true;

        $this->getModuleGenerator($module)->createJob($class, $synchronous);

        $path = Larapie::getModule($module)->getJobs()->getPath() . "/$class.php";
        $stub = "job.stub";
        $namespace = Larapie::getModule($module)->getJobs()->getNamespace();

        /* @var JobGeneratedEvent $event */
        $event = $this->getDispatchedEvents(JobGeneratedEvent::class)->first();
        $this->assertClassBasics(
            $event,
            $module,
            $stub,
            $class,
            $namespace,
            $path);
        $this->assertEquals($synchronous, $event->isSynchronous());
    }

    public function testCreateCommand()
    {
        $module = "User";
        $class = "RandomCommand";
        $consoleCommand = "user:dosomethingrandom";

        $this->getModuleGenerator($module)->createCommand($class, $consoleCommand);

        $path = Larapie::getModule($module)->getCommands()->getPath() . "/$class.php";
        $stub = "command.stub";
        $namespace = Larapie::getModule($module)->getCommands()->getNamespace();


        /* @var CommandGeneratedEvent $event */
        $event = $this->getDispatchedEvents(CommandGeneratedEvent::class)->first();
        $this->assertClassBasics(
            $event,
            $module,
            $stub,
            $class,
            $namespace,
            $path);
        $this->assertEquals($consoleCommand, $event->getConsoleCommand());
    }

    public function testCreateMiddleware()
    {
        $module = "User";
        $class = "RandomMiddleware";

        $this->getModuleGenerator($module)->createMiddleware($class);

        $path = Larapie::getModule($module)->getMiddleWare()->getPath() . "/$class.php";
        $stub = "middleware.stub";
        $namespace = Larapie::getModule($module)->getMiddleWare()->getNamespace();

        /* @var MiddlewareGeneratedEvent $event */
        $event = $this->getDispatchedEvents(MiddlewareGeneratedEvent::class)->first();
        $this->assertClassBasics(
            $event,
            $module,
            $stub,
            $class,
            $namespace,
            $path);
    }

    public function testCreateProvider()
    {
        $module = "User";
        $class = "RandomServiceProvider";

        $this->getModuleGenerator($module)->createServiceProvider($class);

        $path = Larapie::getModule($module)->getServiceProviders()->getPath() . "/$class.php";
        $stub = "provider.stub";
        $namespace = Larapie::getModule($module)->getServiceProviders()->getNamespace();

        /* @var ProviderGeneratedEvent $event */
        $event = $this->getDispatchedEvents(ProviderGeneratedEvent::class)->first();
        $this->assertClassBasics(
            $event,
            $module,
            $stub,
            $class,
            $namespace,
            $path);
    }

    public function testCreateService()
    {
        $module = "User";
        $class = "UserService";

        $this->getModuleGenerator($module)->createService($class);

        $path = Larapie::getModule($module)->getServices()->getPath() . "/$class.php";
        $stub = "service.stub";
        $namespace = Larapie::getModule($module)->getServices()->getNamespace();

        /* @var ServiceGeneratedEvent $event */
        $event = $this->getDispatchedEvents(ServiceGeneratedEvent::class)->first();
        $this->assertClassBasics(
            $event,
            $module,
            $stub,
            $class,
            $namespace,
            $path);
    }

    public function testCreateNotification()
    {
        $module = "User";
        $class = "RandomNotification";

        $this->getModuleGenerator($module)->createNotification($class);

        $path = Larapie::getModule($module)->getNotifications()->getPath() . "/$class.php";
        $stub = "notification.stub";
        $namespace = Larapie::getModule($module)->getNotifications()->getNamespace();

        /* @var NotificationGeneratedEvent $event */
        $event = $this->getDispatchedEvents(NotificationGeneratedEvent::class)->first();
        $this->assertClassBasics(
            $event,
            $module,
            $stub,
            $class,
            $namespace,
            $path);
    }

    public function testCreateModel()
    {
        $module = "User";
        $modelName = "Address";
        $class = $module . $modelName;
        $needsMigration = true;
        $isMongoModel = false;

        $this->getModuleGenerator($module)->createModel($class, $isMongoModel, $needsMigration);

        $path = Larapie::getModule($module)->getModels()->getPath() . "/$module$modelName.php";
        $stub = "model.stub";
        $namespace = Larapie::getModule($module)->getModels()->getNamespace();

        /* @var ModelGeneratedEvent $event */
        $event = $this->getDispatchedEvents(ModelGeneratedEvent::class)->first();
        $this->assertClassBasics(
            $event,
            $module,
            $stub,
            $class,
            $namespace,
            $path
        );

        $stub = "migration.stub";
        $table = "user_addresses";
        $migrationClass = "CreateUserAddressTable";

        /* @var MigrationGeneratedEvent $event */
        $event = $this->getDispatchedEvents(MigrationGeneratedEvent::class)->first();
        $this->assertNotNull($event);
        $this->assertEquals($module, $event->getModuleName());
        $this->assertEquals($stub, $event->getStub()->getName());
        $this->assertEquals($migrationClass, $event->getClassName());
        $this->assertEquals($table, $event->getTableName());
    }

    public function testCreatePolicy()
    {
        $module = "User";
        $class = "UserOwnershipPolicy";

        $this->getModuleGenerator($module)->createPolicy($class,$module);

        $path = Larapie::getModule($module)->getPolicies()->getPath() . "/$class.php";
        $stub = "policy.stub";
        $namespace = Larapie::getModule($module)->getPolicies()->getNamespace();

        /* @var PolicyGeneratedEvent $event */
        $event = $this->getDispatchedEvents(PolicyGeneratedEvent::class)->first();
        $this->assertClassBasics(
            $event,
            $module,
            $stub,
            $class,
            $namespace,
            $path);
    }

    public function testCreateTransformer()
    {
        $module = "User";
        $model = "User";
        $class = "BlablaTransformer";

        $this->getModuleGenerator($module)->createTransformer($class, $model);

        $path = Larapie::getModule($module)->getTransformers()->getPath() . "/$class.php";
        $stub = "transformer.stub";
        $namespace = Larapie::getModule($module)->getTransformers()->getNamespace();
        $modelNamespace = Larapie::getModule($module)->getModels()->getNamespace() . '\\' . Str::studly($model);

        /* @var TransformerGeneratedEvent $event */
        $event = $this->getDispatchedEvents(TransformerGeneratedEvent::class)->first();
        $this->assertClassBasics(
            $event,
            $module,
            $stub,
            $class,
            $namespace,
            $path);
        $this->assertEquals($model, $event->getModel());
        $this->assertEquals($modelNamespace, $event->getModelNamespace());
    }

    public function testCreateUnitTest()
    {
        $module = "User";
        $class = "AUserUnitTest";

        $this->getModuleGenerator($module)->createTest($class, 'unit');

        $path = Larapie::getModule($module)->getTests()->getPath() . "/$class.php";
        $stub = "test-unit.stub";
        $namespace = Larapie::getModule($module)->getTests()->getNamespace();
        $type = "unit";

        /* @var TestGeneratedEvent $event */
        $event = $this->getDispatchedEvents(TestGeneratedEvent::class)->first();
        $this->assertClassBasics(
            $event,
            $module,
            $stub,
            $class,
            $namespace,
            $path);
        $this->assertEquals($type, $event->getType());
    }

    public function testCreateRequest()
    {
        $module = "User";
        $class = "ARequest";

        $this->getModuleGenerator($module)->createRequest($class);

        $path = Larapie::getModule($module)->getRequests()->getPath() . "/$class.php";
        $stub = "request.stub";
        $namespace = Larapie::getModule($module)->getRequests()->getNamespace();

        /* @var RequestGeneratedEvent $event */
        $event = $this->getDispatchedEvents(RequestGeneratedEvent::class)->first();
        $this->assertClassBasics(
            $event,
            $module,
            $stub,
            $class,
            $namespace,
            $path
        );
    }

    public function testCreateRule()
    {
        $module = "User";
        $fileName = "BlalkaRule";

        $this->getModuleGenerator($module)->createRule($fileName);

        $path = Larapie::getModule($module)->getRules()->getPath() . "/$fileName.php";
        $stub = "rule.stub";
        $class = "BlalkaRule";
        $namespace = Larapie::getModule($module)->getRules()->getNamespace();

        /* @var RuleGeneratedEvent $event */
        $event = $this->getDispatchedEvents(RuleGeneratedEvent::class)->first();
        $this->assertClassBasics(
            $event,
            $module,
            $stub,
            $class,
            $namespace,
            $path);
    }

    public function testCreateSeeder()
    {
        $module = "User";
        $class = "BlablaSeeder";

        $this->getModuleGenerator($module)->createSeeder($class);

        $path = Larapie::getModule($module)->getSeeders()->getPath() . "/$class.php";
        $stub = "seeder.stub";
        $namespace = Larapie::getModule($module)->getSeeders()->getNamespace();
        /* @var SeederGeneratedEvent $event */
        $event = $this->getDispatchedEvents(SeederGeneratedEvent::class)->first();
        $this->assertClassBasics(
            $event,
            $module,
            $stub,
            $class,
            $namespace,
            $path);
    }

    public function testCreatePermission()
    {
        $module = "User";
        $class = "UserPermission";

        $this->getModuleGenerator($module)->createPermission($class);

        $path = Larapie::getModule($module)->getPermissions()->getPath() . "/$class.php";
        $stub = "permission.stub";
        $namespace = "Modules\User\Permissions";

        /* @var PermissionGeneratedEvent $event */
        $event = $this->getDispatchedEvents(PermissionGeneratedEvent::class)->first();
        $this->assertClassBasics(
            $event,
            $module,
            $stub,
            $class,
            $namespace,
            $path);
    }

    public function testCreateRoute()
    {
        $moduleName = "Demo";
        $version = 'v1';
        $routename = strtolower(Str::plural($moduleName)) . ".api.$version";

        $this->getModuleGenerator($moduleName)->createRoute($version);

        $expectedFileName = Larapie::getModule($moduleName)->getRoutes()->getPath() . "/$routename.php";
        $expectedStubName = "route.stub";
        $expectedVersion = "v1";

        /* @var RouteGeneratedEvent $event */
        $event = $this->getDispatchedEvents(RouteGeneratedEvent::class)->first();
        $this->assertNotNull($event);

        $this->assertEquals($expectedFileName, $event->getFilePath());
        $this->assertEquals($expectedStubName, $event->getStub()->getName());
        $this->assertEquals($expectedVersion, $event->getVersion());
    }

    public function testCreateComposer()
    {
        $moduleName = "Demo";

        $this->getModuleGenerator($moduleName)->createComposer();

        $expectedFileName = Larapie::getModule($moduleName)->getPath() . "/composer.json";
        $expectedStubName = "composer.stub";

        /* @var ComposerGeneratedEvent $event */
        $event = $this->getDispatchedEvents(ComposerGeneratedEvent::class)->first();
        $this->assertNotNull($event);

        $this->assertEquals($expectedFileName, $event->getFilePath());
        $this->assertEquals($expectedStubName, $event->getStub()->getName());
    }


    /**
     * @param ResourceGenerationContract $event
     * @param string $module
     * @param $stub
     * @param string $class
     * @param string $namespace
     * @param string $path
     */
    private function assertClassBasics(?ResourceGenerationContract $event, string $module, $stub, string $class, string $namespace, string $path)
    {
        $this->assertFileBasics($event, $module, $stub, $path);
        $this->assertEquals($namespace, $event->getNamespace());
        $this->assertEquals($class, $event->getClassName());
        $this->assertEquals($path, $event->getFilePath());
    }

    private function assertFileBasics(?ResourceGenerationContract $event, string $module, $stub, string $path)
    {
        $this->assertNotNull($event);
        $this->assertEquals($module, $event->getModuleName());
        $this->assertEquals($stub, $event->getStub()->getName());
        $this->assertEquals($path, $event->getFilePath());
    }
}
