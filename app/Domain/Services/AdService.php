<?php

namespace App\Domain\Services;

use App\Domain\Models\Ad;
use Illuminate\Support\Facades\DB;

class AdService
{
    /**
     * @param $data
     * @param $requestQuery
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index($data, $requestQuery): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Ad::forCollection()
            ->sorted($data['sortBy'] ?? null, $data['descending'] ?? false)
            ->paginate(10)
            ->appends($requestQuery);
    }

    /**
     * @param $data
     * @return Ad
     */
    public function get($data): Ad
    {
        return Ad::find($data['id']);
    }


    /**
     * @param $data
     * @return array
     */
    public function store($data): array
    {
        return DB::transaction(function () use ($data) {
            $ad = Ad::create($data);
            if (isset($data['photo'])) {
                $ad->photo()->createMany($data['photo']);
            }
            return $ad->only('id');
        });
    }
}
