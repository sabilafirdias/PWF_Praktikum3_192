<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\ProductModel;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Daftarkan Policy untuk ProductModel
        Gate::policy(ProductModel::class, \App\Policies\ProductPolicy::class);

        // 2. Daftarkan Gate 'manage-product'
        Gate::define('manage-product', function (User $user) {
            return $user->role === 'admin';
        });
    }
}