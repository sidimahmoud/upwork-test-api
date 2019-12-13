<?php

namespace App\Console\Commands;

use App\Console\Commands\BaseGeneratorCommand;

class ModuleRepositoryMakeCommand extends BaseGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate repository based on the standard DT structure.';

    /**
     * The type of class being generated
     *
     * @var string
     */
    protected $type = 'Repository';

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
        return __DIR__ . '/stubs/entity_repository.stub';
    }

    /**
     * Get namespace
     *
     * @param string $name
     * @return string
     */
    public function getNamespace($name)
    {
        return parent::getNamespace($name) . '\Repositories';
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
            ['DummyNamespace', 'DummyRootNamespace', 'NamespacedDummyModel', 'DummyPluralClass',
                'DummyModuleNamespace', 'dummyResourceKey'],
            [$this->getNamespace($name), $this->rootNamespace(), $this->getNamespacedModel($name),
                str_plural($this->getClassName($name)), parent::getNamespace($name), $this->getTableName()],
            $stub
        );

        return $this;
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
        $name = str_plural($name);
        $className = str_singular($this->getClassName($name));
        return $this->laravel['path'] . '/' . str_replace('\\', '/', $name) . '/Repositories/' . $className . 'Repository.php';
    }
}
