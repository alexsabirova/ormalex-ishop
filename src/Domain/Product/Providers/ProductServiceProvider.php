<?php

declare(strict_types=1);

namespace Domain\Product\Providers;

use App\Filters\BrandFilter;
use App\Filters\PriceFilter;
use Domain\Catalog\Filters\FilterManager;
use Domain\Catalog\Providers\ActionsServiceProvider;
use Domain\Catalog\Sorters\Sorter;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(
            ActionsServiceProvider::class,
        );
    }

    public function boot(): void
    {

    }
}
