<?php

declare(strict_types=1);

namespace Tests\Feature\App\Http\Controllers;


use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\NoReturn;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ThumbnailControllerTest extends TestCase
{
    use RefreshDatabase;

    #[NoReturn] #[Test]
    public function it_generated_success(): void
    {
        $size = '500x500';
        $method = 'resize';
        $storage = Storage::disk('images');

        config()->set('thumbnail', ['allowed_sizes' => [$size]]);

        $product = ProductFactory::new()->create();

        $response = $this->get($product->makeThumbnail($size, $method));

        $response->assertOk();

        $storage->assertExists(
            "products/$method/$size/" . File::basename($product->thumbnail)
        );
    }
}
