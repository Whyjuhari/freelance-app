<?php

namespace App\Providers;

use App\Models\Projects;
use App\Policies\ProjectPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */


    protected $policies = [
        Projects::class => ProjectPolicy::class,
    ];
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
