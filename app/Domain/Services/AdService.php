<?php

namespace App\Domain\Services;

use App\Domain\DataTransferObjects\AdDTO;
use App\Domain\DataTransferObjects\AdIndexDTO;
use App\Domain\Exceptions\AdNotFound;
use App\Domain\Models\Ad;
use App\Domain\Models\Photo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdService
{
    /**
     * Model
     *
     * @var Model
     */
    protected $model = Ad::class;

    /**
     * Retrieve paginated rows
     *
     * @param AdIndexDTO $DTO
     * @return mixed
     */
    public function index(AdIndexDTO $DTO): mixed
    {
        return $this->model::query()->with(['category'])
            ->category($DTO->category)
            ->sorted($DTO->sortBy, $DTO->descending)
            ->paginate($DTO->rowPerPage)
            ->appends($DTO->requestQuery);
    }

    /**
     * Insert new row
     *
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
            $ad->photo()->saveMany(
                $DTO->photo->count() ? $DTO->photo->toArray() : [Photo::factory()->make()]
            );

            return $ad;
        });
    }

    /**
     * Update exists row
     *
     * @param AdDTO $DTO
     * @return mixed
     */
    public function update(AdDTO $DTO): mixed
    {
        $ad = $this->model::find($DTO->id);

        return DB::transaction(function () use ($ad, $DTO) {
            $ad->update([
                'name' => $DTO->name,
                'description' => $DTO->description,
                'price' => $DTO->price,
                'category_id' => $DTO->category->id,
            ]);

            if ($DTO->photo->count()) {
                $ad->photo()->saveMany($DTO->photo->toArray());
            }

            return $ad;
        });
    }

    /**
     * Delete row
     *
     * @param Ad|int $ad
     * @return bool|null
     */
    public function delete(Ad|int $ad): bool|null
    {
        return DB::transaction(function () use ($ad) {
            return (is_int($ad) ? $this->model::query()->find($ad) : $ad)?->delete() ?? throw new AdNotFound();
        });
    }
}
