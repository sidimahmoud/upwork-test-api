<?php

namespace App\Console\Commands;
use App\Console\Commands\BaseGeneratorCommand;
class ModuleFactoryMakeCommand extends BaseGeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module:factory {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate factory based on the standard DT structure.';

    /**
     * The type of class being generated
     *
     * @var string
     */
    protected $type = 'Factory';

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
        return __DIR__ . '/stubs/entity_factory.stub';
    }

    /**
     * Get path
     *
     * @param string $name
     * @return string
     */
    public function getPath($name)
    {
        return $this->laravel->databasePath() .
            '/factories/' .
            $this->getClassName($name) .
            'Factory.php';
    }
}
