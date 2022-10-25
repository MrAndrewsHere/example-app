<?php

namespace App\Providers;

use App\Domain\QueryListener;
use App\Messages\TgMessage;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //TgMessage::registerTelegramMock();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if (!$this->app->isProduction()) {
            DB::listen(function (QueryExecuted $query) {
                $backtrace = debug_backtrace();
                (new QueryListener(query: $query, backtrace: $backtrace))();
            });
        }
    }
}
