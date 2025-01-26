<?php

declare(strict_types=1);

namespace Domain\Catalog\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;

final class FilterManager
{
    public function __construct(
        protected array $filters = []
    )
    {
    }

    public function registerFilters(array $filters): void
    {
        $this->filters = $filters;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function execute(Builder $query): Builder
    {
        return app(Pipeline::class)
            ->send($query)
            ->through($this->getFilters())
            ->thenReturn();
    }
}
