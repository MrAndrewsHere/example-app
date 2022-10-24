<?php

namespace App\Domain\DataTransferObjects;

use App\Domain\Models\Category;
use App\Domain\Requests\AdIndexRequest;

class AdIndexDTO
{
    public function __construct(
        public readonly ?string   $sortBy,
        public readonly bool      $descending,
        public readonly ?Category $category,
        public readonly int       $rowPerPage,
        public readonly array     $requestQuery
    )
    {
    }

    public static function fromRequest(AdIndexRequest $request): static
    {
        return new static(
            sortBy: $request->get('sortBy') ?? 'created_at',
            descending: $request->has('descending') ? $request->get('descending') : true,
            category: $request->get('category') ? Category::name($request->get('category')) ?? null : null,
            rowPerPage: $request->get('rowPerPage') ?? 12,
            requestQuery: $request->query()
        );
    }
}
