<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\EloquentUserRepository;
use App\Repositories\Eloquent\EloquentCompanyRepository;

use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\CompanyRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * The repository mappings for the application.
     *
     * @var array
     */
    protected $repositories = [
        UserRepository::class => EloquentUserRepository::class,
        CompanyRepository::class => EloquentCompanyRepository::class,
    ];

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $interface => $class) {
            $this->app->singleton($interface, $class);
        }
    }
}
