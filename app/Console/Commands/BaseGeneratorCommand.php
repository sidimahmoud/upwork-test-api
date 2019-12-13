<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

abstract class BaseGeneratorCommand extends GeneratorCommand
{
    /**
     * Get class name
     *
     * @param $name
     * @return mixed
     */
    protected function getClassName($name)
    {
        $names = explode('\\', $name);
        return array_pop($names);
    }

    /**
     * Replace class
     *
     * @param string $stub
     * @param string $name
     * @return mixed
     */
    protected function replaceClass($stub, $name)
    {
        $class = $this->getClassName($name);
        return str_replace('DummyClass', $class, $stub);
    }

    /**
     * Get default namespace
     *
     * @param string $rootNamespace
     * @return string
     */
    public function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Modules';
    }

    /**
     * Get namespace
     *
     * @param string $name
     * @return string
     */
    public function getNamespace($name)
    {
        return parent::getNamespace($name) . '\\' . str_plural($this->getClassName($name));
    }

    /**
     * Get path
     *
     * @param string $name
     * @return string
     */
    public function getPath($name)
    {
        return str_plural($name) . '\\' . $this->getClassName($name) . '.php';
    }

    /**
     * Get namespaced model
     *
     * @param $name
     * @return string
     */
    public function getNamespacedModel($name)
    {
        return self::getNamespace($name) . '\\' . $this->getClassName($name);
    }

    /**
     * Get table name
     *
     * @return string
     */
    public function getTableName()
    {
        return str_plural(
            str_replace('/', '', Str::snake($this->getNameInput()))
        );
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
            ['DummyNamespace', 'DummyRootNamespace', 'NamespacedDummyModel', 'dummyModel', 'dummyTableName'],
            [$this->getNamespace($name), $this->rootNamespace(), $this->getNamespacedModel($name), Str::camel($this->getClassName($name)), $this->getTableName()],
            $stub
        );

        return $this;
    }
}
