<?php

namespace App\Domain\DataTransferObjects;

use App\Domain\Models\Category;
use App\Domain\Requests\AdStoreRequest;

class AdDTO
{
    public function __construct(public ?int $id,
                                public string $name,
                                public ?string $description,
                                public \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection $photos,
                                public Category $category,
                                public int $price
    ) {
    }

    /**
     * @param \App\Domain\Requests\AdUpdateRequest|AdStoreRequest $request
     * @return static
     */
    public static function fromRequest(\App\Domain\Requests\AdUpdateRequest|AdStoreRequest $request): static
    {
        return new static(
            id: $request->get('id') ?? null,
            name: $request->get('name'),
            description: $request->get('description'),
            photos: collect($request->get('photos')),
            category: Category::firstOrCreate(['name' => $request->get('category')]),
            price: (int) $request->get('price')
        );
    }
}
