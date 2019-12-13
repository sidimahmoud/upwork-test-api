<?php

namespace App\Console\Commands;

use App\Console\Commands\BaseGeneratorCommand;
use Illuminate\Support\Str;

class ModuleControllerMakeCommand extends BaseGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module:controller {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate controller based on the standard DT structure.';

    /**
     * The type of class being generated
     *
     * @var string
     */
    protected $type = 'Controller';

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
        return __DIR__ . '/stubs/entity_controller.stub';
    }

    /**
     * Get default namespace
     *
     * @param string $rootNamespace
     * @return string
     */
    public function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Controllers';
    }

    /**
     * Get path
     *
     * @param string $name
     * @return string
     */
    public function getPath($name)
    {
        $name = str_replace_first($this->rootNamespace(), '', $name);

        return $this->laravel['path'] . '/' . str_replace('\\', '/', str_plural($name)) . 'Controller.php';
    }

    /**
     * Get namespace
     *
     * @param string $name
     * @return string
     */
    public function getNamespace($name)
    {
        return trim(implode('\\', array_slice(explode('\\', $name), 0, -1)), '\\');
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
                'DummyNamespace',
                'DummyRootNamespace',
                'dummyModel',
                'DummyModuleNamespace',
                'DummyPluralClass',
                'dummyRepository',
                'dummyPluralModel'
            ],
            [
                $this->getNamespace($name),
                $this->rootNamespace(),
                Str::camel($this->getClassName($name)),
                Str::replaceFirst('Http\Controllers', 'Modules', parent::getNamespace($name)),
                str_plural($this->getClassName($name)),
                Str::camel($this->getClassName($name) . 'Repository'),
                Str::camel(str_plural($this->getClassName($name)))
            ],
            $stub
        );

        return $this;
    }
}
