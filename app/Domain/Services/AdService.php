<?php

namespace App\Domain\Services;

use App\Domain\Models\Ad;
use App\Domain\DataTransferObjects\AdDTO;
use App\Domain\DataTransferObjects\AdsViewDTO;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdService
{
    /**
     * @var Model $model
     */
    protected $model = Ad::class;

    /**
     * @param AdsViewDTO $DTO
     * @return mixed
     */
    public function index(AdsViewDTO $DTO): mixed
    {
        return $this->model::query()->with(['category'])
            ->category($DTO->category)
            ->sorted($DTO->sortBy, $DTO->descending)
            ->paginate($DTO->rowPerPage)
            ->appends($DTO->requestQuery);
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
     * @param AdDTO $DTO
     * @return array
     */
    public function store(AdDTO $DTO): array
    {
        return DB::transaction(function () use ($DTO) {
            $ad = $this->model::query()->create([
                'name' => $DTO->name,
                'description' => $DTO->description,
                'price' => $DTO->price,
                'category_id' => $DTO->category->id
            ]);
            if ($DTO->photos) {
                $ad->photo()->createMany($DTO->photos->toArray());
            }
            return $ad->only('id');
        });
    }

    /**
     * @param Model|int $ad
     * @return bool|null
     */
    public function delete(Model|int $ad): bool|null
    {
        return DB::transaction(function () use ($ad) {
            return (is_int($ad) ? $this->model::query()->find($ad) : $ad)->delete();
        });
    }
}
