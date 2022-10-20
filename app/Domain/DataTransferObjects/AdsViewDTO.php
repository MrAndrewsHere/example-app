<?php

namespace App\Domain\DataTransferObjects;

use App\Domain\Models\Category;
use App\Domain\Requests\AdViewRequest;

class AdsViewDTO
{
    public function __construct(public ?string   $sortBy,
                                public bool      $descending,
                                public ?Category $category,
                                public int       $rowPerPage, public array $requestQuery)
    {
    }

    public static function fromRequest(AdViewRequest $request): static
    {
        return new static(
            sortBy: $request->get('sortBy'),
            descending: (bool)$request->get('descending'),
            category: $request->get('category') ? Category::name($request->get('category'))?->first() : null,
            rowPerPage: $request->get('rowPerPage') ?? 10,
            requestQuery: $request->query()
        );
    }
}
