<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\ProductServiceInterface;
use App\Services\ProductService;
use Inertia\Inertia;
use Session;

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
        // Inertia::share('flash', function () {
        //     return [
        //         'success' => Session::get('success'),
        //         'error' => Session::get('error'),
        //     ];
        // });
       
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        if (app()->environment('local')) {
            $this->app->bind(ProductServiceInterface::class, function () {
                return new ProductService();
            });
        }

    }
}
