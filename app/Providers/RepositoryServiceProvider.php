<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Providers\Service\RepositoryServiceProviderContract as RepositoryServiceProviderContract;
use App\Modules\Users\Contracts\Repositories\UserRepository as InterfaceUser;
use App\Modules\Users\Repositories\UserRepository as RepositoryUser;

class RepositoryServiceProvider extends RepositoryServiceProviderContract
{
    protected $modules = [
        'User',
        'Todo',
        'Setting',
    ];

    /**
     * Register the repositories
     */
    public function register()
    {
        parent::register();
        /*$this->app->bind(
            InterfaceUser::class,
            RepositoryUser::class
        );*/
    }
}
