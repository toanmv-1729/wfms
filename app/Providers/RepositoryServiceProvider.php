<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\EloquentRoleRepository;
use App\Repositories\Eloquent\EloquentUserRepository;
use App\Repositories\Eloquent\EloquentProjectRepository;
use App\Repositories\Eloquent\EloquentCompanyRepository;
use App\Repositories\Eloquent\EloquentPermissionRepository;

use App\Contracts\Repositories\RoleRepository;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\ProjectRepository;
use App\Contracts\Repositories\CompanyRepository;
use App\Contracts\Repositories\PermissionRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * The repository mappings for the application.
     *
     * @var array
     */
    protected $repositories = [
        RoleRepository::class => EloquentRoleRepository::class,
        UserRepository::class => EloquentUserRepository::class,
        ProjectRepository::class => EloquentProjectRepository::class,
        CompanyRepository::class => EloquentCompanyRepository::class,
        PermissionRepository::class => EloquentPermissionRepository::class,
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
