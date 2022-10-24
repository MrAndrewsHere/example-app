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
    public function __construct(
        public readonly ?int                                 $id,
        public readonly string                               $name,
        public readonly ?string                              $description,
        public readonly SupportCollection|EloquentCollection $photo,
        public readonly Category|Model                       $category,
        public readonly int                                  $price
    ) {
    }

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
