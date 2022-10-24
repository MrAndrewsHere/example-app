<?php

namespace App\Providers;

use App\Messages\SqlQueryTakeTooLongTime;
use App\Notifications\TelegramNotification;
use Illuminate\Database\Events\QueryExecuted;
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
        if (!$this->app->isProduction()) {
            DB::listen(function (QueryExecuted $query) {
                if ($query->time > 200) {
                    $backtrace = collect(debug_backtrace());
                    $location = $backtrace->filter(function ($trace) {
                        return isset($trace['file']) && (!str_contains($trace['file'], 'vendor') || !str_contains($trace['file'], 'seeder'));
                    })->first(); // берем первый элемент не из каталога вендора


                    $bindings = implode(', ', $query->bindings);

                    $info = "
               ------------
               Sql: $query->sql
               Bindings: $bindings
               Time: $query->time ms
               File: ${location['file']}
               Line: ${location['line']}
               ------------
        ";
                    try {
                        (new SqlQueryTakeTooLongTime($query->time))->notify(new TelegramNotification());
                    } catch (\Throwable $exception) {
                        Log::error($exception->getMessage());
                    }


                    Log::info($info);
                }
            });
        }
    }
}
