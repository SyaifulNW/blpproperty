<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;

use App\Models\Produk; // Ensure you import the Produk model


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
         View::composer('*', function ($view) {
        $view->with('kelas', \App\Models\Produk::all());
    });
     if (config('app.env') === 'production') {
        URL::forceScheme('https');
    }
    }
}
