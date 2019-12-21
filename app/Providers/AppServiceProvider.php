<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\Ticket;
use App\Observers\RoleObserver;
use App\Observers\TicketObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Role::observe(RoleObserver::class);
        Ticket::observe(TicketObserver::class);
    }
}
