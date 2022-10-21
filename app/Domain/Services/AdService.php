<?php

namespace App\Domain\Services;

use App\Domain\DataTransferObjects\AdDTO;
use App\Domain\DataTransferObjects\AdsIndexDTO;
use App\Domain\Models\Ad;
use App\Domain\Models\Photo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdService
{
    /**
     * @var Model
     */
    protected $model = Ad::class;

    /**
     * @param AdsIndexDTO $DTO
     * @return mixed
     */
    public function index(AdsIndexDTO $DTO): mixed
    {
        return $this->model::query()->with(['category'])
            ->category($DTO->category)
            ->sorted($DTO->sortBy, $DTO->descending)
            ->paginate($DTO->rowPerPage)
            ->appends($DTO->requestQuery);
    }

    /**
     * @param $data
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder[]|Model
     */
    public function get($data): \Illuminate\Database\Eloquent\Builder|array|\Illuminate\Database\Eloquent\Collection|Model
    {
        return $this->model::query()->find($data['id']);
    }

    /**
     * @param AdDTO $DTO
     * @return array
     */
    public function store(AdDTO $DTO): Ad
    {
        return DB::transaction(function () use ($DTO) {
            $ad = $this->model::query()->create([
                'name' => $DTO->name,
                'description' => $DTO->description,
                'price' => $DTO->price,
                'category_id' => $DTO->category->id,
            ]);
            $ad->photo()->createMany(
                $DTO->photos->count() ?
                    $DTO->photos->toArray() :
                    [Photo::factory()->make()->toArray()]);

            return $ad;
        });
    }

    /**
     * @param AdDTO $DTO
     * @return mixed
     */
    public function update(AdDTO $DTO): mixed
    {
        $ad = $this->model::query()->find($DTO->id);

        return DB::transaction(function () use ($ad, $DTO) {
            $ad->update([
                'name' => $DTO->name,
                'description' => $DTO->description,
                'price' => $DTO->price,
                'category_id' => $DTO->category->id,
            ]);

            if ($DTO->photos->count()) {
                $ad->photo()->createMany($DTO->photos->toArray());
            }

            return $ad;
        });
    }

    /**
     * @param Ad|int $ad
     * @return bool|null
     */
    public function delete(Ad|int $ad): bool|null
    {
        return DB::transaction(function () use ($ad) {
            return (is_int($ad) ? $this->model::query()->find($ad) : $ad)->delete();
        });
    }
}
