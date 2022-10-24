<?php

namespace App\Domain\DataTransferObjects;

use App\Domain\Models\Category;
use App\Domain\Requests\AdIndexRequest;

class AdsIndexDTO
{
    public function __construct(
        public ?string $sortBy,
        public bool $descending,
        public ?Category $category,
        public int $rowPerPage,
        public array $requestQuery
    ) {
    }

    /**
     * @param AdIndexRequest $request
     * @return static
     */
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
