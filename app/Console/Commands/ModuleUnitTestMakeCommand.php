<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use App\Console\Commands\BaseGeneratorCommand;

class ModuleUnitTestMakeCommand extends BaseGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module:unit:test {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate unit test based on the standard DT structure.';

    /**
     * The type of class being generated
     *
     * @var string
     */
    protected $type = 'Unit Test';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        return parent::handle();
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/entity_unit_test.stub';
    }

    /**
     * Root namespace
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return 'Tests';
    }

    /**
     * Get default namespace
     *
     * @param string $rootNamespace
     * @return string
     */
    public function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Unit';
    }

    /**
     * Get path
     *
     * @param string $name
     * @return string
     */
    public function getPath($name)
    {
        $path = str_plural(
            Str::replaceFirst($this->rootNamespace(), '', $name)
        );

        return base_path('tests') .
            str_replace('\\', '/', $path) . '/' . $this->getClassName($name) .
            'UnitTest.php';
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $stub = str_replace(
            [
                'DummyTestNamespace',
                'DummyRootNamespace',
                'NamespacedDummyModel',
                'DummyPluralClass',
                'DummyModuleNamespace',
                'dummyResourceKey',
                'dummyTableName',
                'dummyRepository',
                'dummyModel',
                'dummyPluralModel',
                'dummySnakeModel',
                'dummyPluralSnakeModel',
                'DUMMY_TABLE_NAME'
            ],
            [
                $this->getNamespace($name),
                $this->rootNamespace(),
                Str::replaceFirst($this->rootNamespace() . '\Unit', 'App\Modules', $this->getNamespacedModel($name)),
                str_plural($this->getClassName($name)),
                Str::replaceFirst($this->rootNamespace() . '\Unit', 'App\Modules', parent::getNamespace($name)),
                $this->getTableName(),
                $this->getTableName(),
                Str::camel($this->getClassName($name)) . 'Repository',
                Str::camel($this->getClassName($name)),
                str_plural(Str::camel($this->getClassName($name))),
                Str::snake($this->getClassName($name)),
                str_plural(Str::snake($this->getClassName($name))),
                strtoupper(str_plural(Str::snake($this->getClassName($name))) . '_table')
            ],
            $stub
        );

        return $this;
    }
}
