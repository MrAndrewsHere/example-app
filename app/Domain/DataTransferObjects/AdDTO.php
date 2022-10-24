<?php

namespace App\Domain\DataTransferObjects;

use App\Domain\Models\Category;
use App\Domain\Requests\AdStoreRequest;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as SupportCollection;
use App\Domain\Requests\AdUpdateRequest;

class AdDTO
{
    /**
     * @param int|null $id
     * @param string $name
     * @param string|null $description
     * @param SupportCollection|EloquentCollection $photo
     * @param Category|Model $category
     * @param int $price
     */
    public function __construct(
        public ?int                                 $id,
        public string                               $name,
        public ?string                              $description,
        public SupportCollection|EloquentCollection $photo,
        public Category|Model                       $category,
        public int                                  $price
    ) {
    }

    /**
     * @param AdUpdateRequest|AdStoreRequest $request
     * @return static
     */
    public static function fromRequest(AdUpdateRequest|AdStoreRequest $request): static
    {
        return new static(
            id: $request->get('id') ?? null,
            name: $request->get('name'),
            description: $request->get('description'),
            photo: collect($request->get('photos'))->map(fn ($i) => new Category(...$i)),
            category: Category::query()->firstOrCreate(['name' => $request->get('category')]),
            price: (int)$request->get('price')
        );
    }
}
