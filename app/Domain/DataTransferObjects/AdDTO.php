<?php

namespace App\Domain\DataTransferObjects;

use App\Domain\Models\Category;

class AdDTO
{
    public function __construct(public string                                                                  $name,
                                public ?string                                                                 $description,
                                public \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection $photos,
                                public Category                                                                $category,
                                public int                                                                     $price
    )
    {
    }

    public static function fromRequest(\App\Domain\Requests\AdStoreRequest $request): static
    {
        return new static(
            name: $request->get('name'),
            description: $request->get('description'),
            photos: collect($request->get('photos')),
            category: Category::query()->firstOrCreate(['name'], ['name' => $request->get('category')]),
            price: (int)$request->get('price')
        );
    }
}
