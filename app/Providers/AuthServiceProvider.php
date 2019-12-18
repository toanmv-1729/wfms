<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\Staff;

use App\Policies\RolePolicy;
use App\Policies\StaffPolicy;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Role::class => RolePolicy::class,
        Staff::class => StaffPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('roles.edit', 'App\Policies\RolePolicy@edit');
        Gate::define('roles.store', 'App\Policies\RolePolicy@store');
        Gate::define('roles.index', 'App\Policies\RolePolicy@index');
        Gate::define('roles.create', 'App\Policies\RolePolicy@create');
        Gate::define('roles.update', 'App\Policies\RolePolicy@update');
        Gate::define('roles.destroy', 'App\Policies\RolePolicy@destroy');

        Gate::define('staffs.edit', 'App\Policies\StaffPolicy@edit');
        Gate::define('staffs.store', 'App\Policies\StaffPolicy@store');
        Gate::define('staffs.index', 'App\Policies\StaffPolicy@index');
        Gate::define('staffs.create', 'App\Policies\StaffPolicy@create');
        Gate::define('staffs.update', 'App\Policies\StaffPolicy@update');
        Gate::define('staffs.destroy', 'App\Policies\StaffPolicy@destroy');
        Gate::define('staffs.getMyProjects', 'App\Policies\StaffPolicy@getMyProjects');
        Gate::define('staffs.getProjectOverview', 'App\Policies\StaffPolicy@getProjectOverview');
    }
}
