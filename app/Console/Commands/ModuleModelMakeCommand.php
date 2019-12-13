<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Commands\BaseGeneratorCommand;
class ModuleModelMakeCommand extends BaseGeneratorCommand
{
      /**
       * The name and signature of the console command.
       *
       * @var string
       */
      protected $signature = 'make:module:model {name}';

      /**
       * The console command description.
       *
       * @var string
       */
      protected $description = 'Generate model based on the standard Digital consulting structure.';

      /**
       * The type of class being generated
       *
       * @var string
       */
      protected $type = 'Model';

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
          return __DIR__ . '/stubs/entity_model.stub';
      }

      public function getPath($name)
      {
          $name = str_replace_first($this->rootNamespace(), '', $name);

          return $this->laravel['path'] . '/' . str_replace('\\', '/', str_plural($name)) . '/' . $this->getClassName($name) . '.php';
      }

}
