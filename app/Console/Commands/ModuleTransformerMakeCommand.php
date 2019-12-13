<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use App\Console\Commands\BaseGeneratorCommand;

class ModuleTransformerMakeCommand extends BaseGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module:transformer {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate transformer based on the standard DT structure.';

    /**
     * The type of class being generated
     *
     * @var string
     */
    protected $type = 'Transformer';

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
        return __DIR__ . '/stubs/entity_transformer.stub';
    }

    /**
     * Get namespace
     *
     * @param string $name
     * @return string
     */
    public function getNamespace($name)
    {
        return parent::getNamespace($name) . '\Transformers';
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
            ['DummyNamespace', 'DummyRootNamespace', 'NamespacedDummyModel', 'dummyModel'],
            [$this->getNamespace($name), $this->rootNamespace(), $this->getNamespacedModel($name), Str::camel($this->getClassName($name))],
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

        return $this->laravel['path'] . '/' . str_replace('\\', '/', str_plural($name)) . '/Transformers/' . $this->getClassName($name) . 'Transformer.php';
    }
}
