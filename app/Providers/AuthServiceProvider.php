<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\Staff;
use App\Models\Team;
use App\Models\Ticket;
use App\Models\Project;
use App\Models\Version;

use App\Policies\RolePolicy;
use App\Policies\StaffPolicy;
use App\Policies\TeamPolicy;
use App\Policies\TicketPolicy;
use App\Policies\ProjectPolicy;
use App\Policies\VersionPolicy;

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
        Team::class => TeamPolicy::class,
        Ticket::class => TicketPolicy::class,
        Project::class => ProjectPolicy::class,
        Version::class => VersionPolicy::class,
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

        Gate::define('projects.edit', 'App\Policies\ProjectPolicy@edit');
        Gate::define('projects.store', 'App\Policies\ProjectPolicy@store');
        Gate::define('projects.index', 'App\Policies\ProjectPolicy@index');
        Gate::define('projects.create', 'App\Policies\ProjectPolicy@create');
        Gate::define('projects.update', 'App\Policies\ProjectPolicy@update');

        Gate::define('staffs.edit', 'App\Policies\StaffPolicy@edit');
        Gate::define('staffs.store', 'App\Policies\StaffPolicy@store');
        Gate::define('staffs.index', 'App\Policies\StaffPolicy@index');
        Gate::define('staffs.create', 'App\Policies\StaffPolicy@create');
        Gate::define('staffs.update', 'App\Policies\StaffPolicy@update');
        Gate::define('staffs.destroy', 'App\Policies\StaffPolicy@destroy');
        Gate::define('staffs.getMyProjects', 'App\Policies\StaffPolicy@getMyProjects');
        Gate::define('staffs.getProjectOverview', 'App\Policies\StaffPolicy@getProjectOverview');

        Gate::define('users.getProfile', 'App\Policies\ProfilePolicy@getProfile');
        Gate::define('users.updateProfile', 'App\Policies\ProfilePolicy@updateProfile');
        Gate::define('users.updatePassword', 'App\Policies\ProfilePolicy@updatePassword');

        Gate::define('tickets.all', 'App\Policies\TicketPolicy@all');
        Gate::define('tickets.edit', 'App\Policies\TicketPolicy@edit');
        Gate::define('tickets.store', 'App\Policies\TicketPolicy@store');
        Gate::define('tickets.show', 'App\Policies\TicketPolicy@show');
        Gate::define('tickets.index', 'App\Policies\TicketPolicy@index');
        Gate::define('tickets.create', 'App\Policies\TicketPolicy@create');
        Gate::define('tickets.update', 'App\Policies\TicketPolicy@update');
        Gate::define('tickets.destroy', 'App\Policies\TicketPolicy@destroy');
        Gate::define('tickets.createSubTicket', 'App\Policies\TicketPolicy@createSubTicket');
        Gate::define('tickets.addRelationTicket', 'App\Policies\TicketPolicy@addRelationTicket');

        Gate::define('teams.store', 'App\Policies\TeamPolicy@store');
        Gate::define('teams.index', 'App\Policies\TeamPolicy@index');
        Gate::define('teams.update', 'App\Policies\TeamPolicy@update');
        Gate::define('teams.destroy', 'App\Policies\TeamPolicy@destroy');

        Gate::define('versions.store', 'App\Policies\VersionPolicy@store');
        Gate::define('versions.index', 'App\Policies\VersionPolicy@index');
        Gate::define('versions.update', 'App\Policies\VersionPolicy@update');
        Gate::define('versions.destroy', 'App\Policies\VersionPolicy@destroy');

        Gate::define('documents.store', 'App\Policies\DocumentPolicy@store');
        Gate::define('documents.index', 'App\Policies\DocumentPolicy@index');
        Gate::define('documents.update', 'App\Policies\DocumentPolicy@update');
        Gate::define('documents.destroy', 'App\Policies\DocumentPolicy@destroy');
        Gate::define('documents.indexChild', 'App\Policies\DocumentPolicy@indexChild');

        Gate::define('samples.store', 'App\Policies\SamplePolicy@store');
        Gate::define('samples.index', 'App\Policies\SamplePolicy@index');
        Gate::define('samples.update', 'App\Policies\SamplePolicy@update');
        Gate::define('samples.destroy', 'App\Policies\SamplePolicy@destroy');
    }
}
