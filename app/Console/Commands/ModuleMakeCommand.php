<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ModuleMakeCommand extends Command
{
      /**
       * The name and signature of the console command.
       *
       * @var string
       */
      protected $signature = 'make:module {name} {--controller}';

      /**
       * The console command description.
       *
       * @var string
       */
      protected $description = 'Generate the necessary files for the module';

      /**
       * Execute the console command.
       */
      public function handle()
      {
          $this->createMigration();
          $this->createModel();
          $this->createTransformer();
          $this->createRepository();
          $this->createFactory();
          $this->createUnitTest();

          if ($this->option('controller')) {
              $this->createController();
          }
      }

      /**
       * Create migration
       */
      private function createMigration()
      {
          $this->call('make:migration', [
              'name' => 'create_' . Str::snake(str_replace('/', '', str_plural($this->argument('name')))) . '_table'
          ]);
      }

      /**
       * Create model
       */
      private function createModel()
      {
          $this->call('make:module:model', [
              'name' => $this->argument('name')
          ]);
      }

      /**
       * Create transformer
       */
      private function createTransformer()
      {
          $this->call('make:module:transformer', [
              'name' => $this->argument('name')
          ]);
      }

      /**
       * Create repository
       */
      private function createRepository()
      {
          $this->call('make:module:repository:contract', [
              'name' => $this->argument('name')
          ]);
          $this->call('make:module:repository', [
              'name' => $this->argument('name')
          ]);
      }

      /**
       * Create factory
       */
      private function createFactory()
      {
          $this->call('make:module:factory', [
              'name' => $this->argument('name')
          ]);
      }

      /**
       * Create unit test
       */
      private function createUnitTest()
      {
          $this->call('make:module:unit:test', [
              'name' => $this->argument('name')
          ]);
      }



      /**
       * Create controller
       */
      private function createController()
      {
          $this->call('make:module:controller', [
              'name' => $this->argument('name')
          ]);
      }

}
