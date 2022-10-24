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
        //При долгом выполнении sql запроса логируем его и отправляем оповещение
        if (!$this->app->isProduction()) {
            DB::listen(function (QueryExecuted $query) {
                if ($query->time > env('MAX_SQL_QUERY_TTL_TO_NOTIFY',1000)) {
                    $backtrace = collect(debug_backtrace());
                    $location = $backtrace->filter(function ($trace) {
                        return isset($trace['file']) && (!str_contains($trace['file'], 'vendor') || !str_contains($trace['file'], 'seeder'));
                    })->first(); // берем первый элемент не из каталога вендора и не сидер


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
