<?php

declare(strict_types=1);

namespace Domain\Product\QueryBuilders;

use Domain\Catalog\Facades\Filter;
use Domain\Catalog\Facades\Sorter;
use Domain\Catalog\Models\Category;
use Domain\Product\Builders\ProductBuilder;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;

final class ProductQueryBuilder extends Builder
{
    private const FULL_TEXT_COLUMNS = ['title', 'text'];

    public function homePage(): ProductQueryBuilder
    {
        return $this->where('on_home_page', true)
            ->orderBy('sorting')
            ->limit(8);
    }

    public function filtered(): ProductQueryBuilder
    {
        return app(Pipeline::class)
            ->send($this)
            ->through(filters())
            ->thenReturn();
    }

    public function withFiltering()
    {
        return Filter::execute($this);
    }

    public function sorted(): Builder|ProductQueryBuilder
    {
        return Sorter::run($this);
    }

    public function withSorting(): Builder|ProductBuilder
    {
        return Sorter::execute($this);
    }

    public function viewed(Product $current)
    {
        return $this->where(function (Builder $query) use ($current) {
            $query
                ->whereIn('id', session('viewed_products', []))
                ->where('id', '!=', $current->id);
        });
    }

    public function search(): ProductQueryBuilder
    {
        return $this->when(request('s'), function (Builder $query) {
            $query->whereFullText(['title', 'text'], request('s'));
        });
    }

    public function withSearch(?string $search)
    {
        return $this->when($search, function (Builder $query) use ($search) {
            $query->whereFullText(self::FULL_TEXT_COLUMNS, $search);
        });
    }

    public function withCategory(Category $category): ProductQueryBuilder
    {
        return $this->when($category->exists, function (Builder $query) use ($category) {
            $query->whereRelation(
                'categories',
                'categories.id',
                '=',
                $category->id
            );
        });
    }
}
