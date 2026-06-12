<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\PermintaanBarang;

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
            View::composer('*', function ($view) {

                $query = PermintaanBarang::where(
                    'status',
                    'Menunggu'
                );

                if (
                    auth()->check()
                    &&
                    auth()->user()->cabang
                ) {

                    $query->where(
                        'cabang',
                        auth()->user()->cabang
                    );

                }

                $jumlahPermintaan = $query->count();

                $view->with(
                    'jumlahPermintaan',
                    $jumlahPermintaan
                );

            });
        }
}
