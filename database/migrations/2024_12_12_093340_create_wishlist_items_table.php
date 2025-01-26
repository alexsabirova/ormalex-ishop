<?php

use Domain\Product\Models\OptionValue;
use Domain\Product\Models\Product;
use Domain\Wishlist\Models\Wishlist;
use Domain\Wishlist\Models\WishlistItem;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wishlist_items', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Wishlist::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignIdFor(Product::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->unsignedBigInteger('price');

            $table->string('string_option_values')
                ->nullable();

            $table->timestamps();
        });

        Schema::create('wishlist_item_option_value', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(WishlistItem::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignIdFor(OptionValue::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        if(!app()->isProduction()) {
            Schema::dropIfExists('wishlist_items');
        }
    }
};
