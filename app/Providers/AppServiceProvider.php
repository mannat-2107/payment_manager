<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use App\Http\Responses\LoginResponse;
use App\Models\SalaryStructure;
use App\Observers\SalaryStructureObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(LoginResponseContract::class, LoginResponse::class);
    }

    public function boot(): void
    {
        SalaryStructure::observe(SalaryStructureObserver::class);
    }
}