<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\EloquentRoleRepository;
use App\Repositories\Eloquent\EloquentUserRepository;
use App\Repositories\Eloquent\EloquentTeamRepository;
use App\Repositories\Eloquent\EloquentTicketRepository;
use App\Repositories\Eloquent\EloquentProjectRepository;
use App\Repositories\Eloquent\EloquentVersionRepository;
use App\Repositories\Eloquent\EloquentCompanyRepository;
use App\Repositories\Eloquent\EloquentDocumentRepository;
use App\Repositories\Eloquent\EloquentPermissionRepository;
use App\Repositories\Eloquent\EloquentSpendTimeRepository;
use App\Repositories\Eloquent\EloquentTicketHistoryRepository;
use App\Repositories\Eloquent\EloquentTicketRelationRepository;

use App\Contracts\Repositories\RoleRepository;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\TeamRepository;
use App\Contracts\Repositories\TicketRepository;
use App\Contracts\Repositories\ProjectRepository;
use App\Contracts\Repositories\VersionRepository;
use App\Contracts\Repositories\CompanyRepository;
use App\Contracts\Repositories\DocumentRepository;
use App\Contracts\Repositories\PermissionRepository;
use App\Contracts\Repositories\SpendTimeRepository;
use App\Contracts\Repositories\TicketHistoryRepository;
use App\Contracts\Repositories\TicketRelationRepository;

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
        TeamRepository::class => EloquentTeamRepository::class,
        TicketRepository::class => EloquentTicketRepository::class,
        ProjectRepository::class => EloquentProjectRepository::class,
        VersionRepository::class => EloquentVersionRepository::class,
        CompanyRepository::class => EloquentCompanyRepository::class,
        DocumentRepository::class => EloquentDocumentRepository::class,
        PermissionRepository::class => EloquentPermissionRepository::class,
        SpendTimeRepository::class => EloquentSpendTimeRepository::class,
        TicketHistoryRepository::class => EloquentTicketHistoryRepository::class,
        TicketRelationRepository::class => EloquentTicketRelationRepository::class,
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
