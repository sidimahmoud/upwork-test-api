<?php

namespace App\Providers\Service;

use Illuminate\Support\ServiceProvider;

abstract class RepositoryServiceProviderContract extends ServiceProvider
{
    protected $modules = [];
    protected $moduleDirectory = 'App\Modules';
    protected $contractDirectory = 'Contracts\Repositories';
    protected $repositoryDirectory = 'Repositories';

    /**
     * Get model name from module
     *
     * @param string $module
     * @return string
     */
    private function getModelName(string $module): string
    {
        $chunks = explode('\\', $module);
        return array_pop($chunks);
    }

    /**
     * Get repository class name
     *
     * @param string $module
     * @return string
     */
    private function getRepositoryClassName(string $module): string
    {
        return $this->getModelName($module) . 'Repository';
    }

    /**
     * Get repository contract class by module name
     *
     * @param string $module
     * @return string
     */
    private function getRepositoryContractClassByModule(string $module): string
    {
        $fqcn = $this->moduleDirectory . '\\' . str_plural($module) . '\\' . $this->contractDirectory . '\\' . $this->getRepositoryClassName($module);
        return $fqcn;
    }

    /**
     * Get repository class by module name
     *
     * @param string $module
     * @return string
     */
    private function getRepositoryClassByModule(string $module): string
    {
        $fqcn = $this->moduleDirectory . '\\' . str_plural($module) . '\\' . $this->repositoryDirectory . '\\' . $this->getRepositoryClassName($module);
        return $fqcn;
    }

    /**
     * Register the repositories
     */
    public function register()
    {
        foreach ($this->modules as $module) {
            $this->app->bind(
                $this->getRepositoryContractClassByModule($module),
                $this->getRepositoryClassByModule($module)
            );
        }
    }
}
