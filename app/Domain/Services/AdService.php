<?php

namespace App\Domain\Services;

use App\Domain\Models\Ad;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdService
{
    /**
     * @var Model $model
     */
    protected $model = Ad::class;

    /**
     * @param $data
     * @param $requestQuery
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index($data, $requestQuery): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->model::query()->forCollection()
            ->sorted($data['sortBy'] ?? null, $data['descending'] ?? false)
            ->paginate($data['rowPerPage'] ?? 10)
            ->appends($requestQuery);
    }

    /**
     * @param $data
     * @return Model
     */
    public function get($data): Model
    {
        return $this->model::query()->find($data['id']);
    }


    /**
     * @param $data
     * @return array
     */
    public function store($data): array
    {
        return DB::transaction(function () use ($data) {
            $ad = $this->model::query()->create($data);
            if (isset($data['photo'])) {
                $ad->photo()->createMany($data['photo']);
            }
            return $ad->only('id');
        });
    }

    /**
     * @param $data
     * @return bool|null
     */
    public function delete($id): bool|null
    {
        return DB::transaction(function () use ($id) {
            return $this->model::query()->find($id)->delete();
        });
    }
}
