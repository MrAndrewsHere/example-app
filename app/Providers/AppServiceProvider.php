<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

        if (env('APP_ENV') === 'development') {
            DB::listen(function ($query) {
                $location = collect(debug_backtrace())->filter(function ($trace) {
                    return !str_contains($trace['file'] ?? '', 'vendor/');
                })->first(); // берем первый элемент не из каталога вендора
                $bindings = implode(", ", $query->bindings); // форматируем привязку как строку

                Log::info("
               ------------
               Sql: $query->sql
               Bindings: $bindings
               Time: $query->time
               File: ${location['file']}
               Line: ${location['line']}
               ------------
        ");
            });

        }
    }
}
