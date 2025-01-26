<?php

namespace Feature\App\Http\Controllers;


use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Requests\LoginFormRequest;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\ProductFactory;
use Database\Factories\UserFactory;
use Domain\Cart\CartManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use JetBrains\PhpStorm\NoReturn;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        CartManager::fake();
    }

    public function getProduct()
    {
        return ProductFactory::new()->create();
    }

    #[NoReturn] #[Test]
    public function it_is_empty_cart(): void
    {
        $this->get(action([CartController::class, 'index']))
            ->assertOk()
            ->assertViewIs('cart.index')
            ->assertViewHas('items', collect([]));
    }

    #[NoReturn] #[Test]
    public function it_is_not_empty_cart(): void
    {
        cart()->add($this->getProduct());

        $this->get(action([CartController::class, 'index']))
            ->assertOk()
            ->assertViewIs('cart.index')
            ->assertViewHas('items', cart()->items());
    }

    #[NoReturn] #[Test]
    public function it_added_success(): void
    {
        $this->assertEquals(0, cart()->count());

        $this->post(
            action([CartController::class, 'add'], $this->getProduct()),
            ['quantity' => 5]
        );

        $this->assertEquals(5, cart()->count());
    }

    #[NoReturn] #[Test]
    public function it_quantity_changed(): void
    {
        cart()->add($this->getProduct(), 5);

        $this->assertEquals(5, cart()->count());

        $this->post(
            action([CartController::class, 'quantity'], cart()->items()->first()),
            ['quantity' => 10]
        );

        $this->assertEquals(10, cart()->count());
    }

    #[NoReturn] #[Test]
    public function it_delete_success(): void
    {
        cart()->add($this->getProduct(), 5);

        $this->assertEquals(5, cart()->count());

        $this->delete(
            action([CartController::class, 'delete'], cart()->items()->first()),
        );

        $this->assertEquals(0, cart()->count());
    }

    #[NoReturn] #[Test]
    public function it_truncate_success(): void
    {
        cart()->add($this->getProduct(), 4);

        $this->assertEquals(4, cart()->count());

        $this->delete(
            action([CartController::class, 'truncate']),
        );

        $this->assertEquals(0, cart()->count());
    }
}



