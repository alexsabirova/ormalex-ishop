<?php

namespace Tests\Feature\App\Http\Controllers;


use App\Http\Controllers\CatalogController;
use Database\Factories\BrandFactory;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JetBrains\PhpStorm\NoReturn;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CatalogControllerTest extends TestCase
{
    use RefreshDatabase;

    #[NoReturn] #[Test]
    public function it_success_price_filtered_response(): void
    {
        $products = ProductFactory::new()
            ->count(10)
            ->create(['price' => 500]);

        $expectedProduct = ProductFactory::new()
            ->createOne(['price' => 100000]);
        $request  = [
            'filters' => [
                'price' => ['from' => 999, 'to' => 1001],
            ],
        ];

        $this->get(action(CatalogController::class, $request))
            ->assertOk()
            ->assertSee($expectedProduct->title)
            ->assertDontSee($products->random()->first()->title);
    }

    #[NoReturn] #[Test]
    public function it_success_brand_filtered_response(): void
    {
        $products = ProductFactory::new()
            ->count(10)
            ->create();

        $brand = BrandFactory::new()->create();

        $expectedProduct = ProductFactory::new()
            ->createOne(['brand_id' => $brand]);

        $request  = [
            'filters' => [
                'brands' => [$brand->id => $brand->id],
            ],
        ];

        $this->get(action(CatalogController::class, $request))
            ->assertOk()
            ->assertSee($expectedProduct->title)
            ->assertDontSee($products->random()->first()->title);
    }

    #[NoReturn] #[Test]
    public function it_success_sorted_response(): void
    {
        $products = ProductFactory::new()
            ->count(3)
            ->create();

        $request  = [
            'sort' => 'title',
        ];

        $this->get(action(CatalogController::class, $request))
            ->assertOk()
            ->assertSeeInOrder(
                $products->sortBy('title')
                ->flatMap(fn($item) => [$item->title])
                ->toArray()
            );
    }
}



