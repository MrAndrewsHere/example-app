<?php

namespace App\Domain;

use App\Messages\SqlQueryTakeTooLongTime;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

/**
 * При долгом выполнении sql запроса логируем его и отправляем оповещение
 */
class QueryListener
{
    public function __construct(
        protected QueryExecuted    $query,
        protected array|Collection $backtrace,
        protected ?int             $MAX_SQL_QUERY_TIME_BEFORE_NOTIFY = null
    )
    {
        $this->backtrace = collect($this->backtrace);
        $this->MAX_SQL_QUERY_TIME_BEFORE_NOTIFY = env('MAX_SQL_QUERY_TIME_BEFORE_NOTIFY', 150);
    }

    public function handle(): void
    {
        ;
        $sql = $this->query->sql;
        $location = $this->location();
        $file = $location['file'] ?? '';
        $line = $location['line'] ?? '';
        $time = $this->query->time;
        $bindings = implode(', ', $this->query->bindings);

        $info = "
               ------------
               Sql: $sql
               Bindings: $bindings
               Time: $time ms
               File: ${file}
               Line: ${line}
               ------------
        ";

        if ($this->MAX_SQL_QUERY_TIME_BEFORE_NOTIFY && $time > $this->MAX_SQL_QUERY_TIME_BEFORE_NOTIFY) {
            Log::info($info);
            (new SqlQueryTakeTooLongTime(message: $info, time: $time))();
        }
    }

    /**
     * Первый элемент не из каталога вендора и не сидер
     *
     * @return mixed
     */
    protected function location(): mixed
    {
        return $this->backtrace->filter(function ($trace) {
            return isset($trace['file'])
                && (
                    !str_contains($trace['file'], 'vendor')
                    && !str_contains($trace['file'], 'seeder')
                );
        })?->first();
    }

    public function __invoke(): void
    {
        $this->handle();
    }
}
