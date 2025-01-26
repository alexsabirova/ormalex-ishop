<?php

declare(strict_types=1);

namespace Domain\Wishlist;



use Domain\Product\Models\Product;
use Domain\Wishlist\Contracts\WishlistIdentityStorageContract;
use Domain\Wishlist\Models\Wishlist;
use Domain\Wishlist\Models\WishlistItem;
use Domain\Wishlist\StorageIdentities\FakeIdentityStorage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;


class WishlistManager
{
    public function __construct(
        protected WishlistIdentityStorageContract $identityStorage
    )
    {
    }

    public static function fake(): void
    {
        app()->bind(WishlistIdentityStorageContract::class, FakeIdentityStorage::class);
    }

    private function cacheKey(): string
    {
        return str('wishlist_' . $this->identityStorage->get())
            ->slug('_')
            ->value();
    }

    private function forgetCache(): void
    {
        Cache::forget($this->cacheKey());
    }

    private function storedData(string $id): array
    {
        $data = [
            'storage_id' => $id
        ];

        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        }

        return $data;
    }

    private function stringedOptionValues(array $optionValues = []): string
    {
        sort($optionValues);

        return implode(';', $optionValues);
    }

    public function updateStorageId(string $old, string $current): void
    {
        Wishlist::query()
            ->where('storage_id', $old)
            ->update($this->storedData($current));
    }


    public function add(Product $product, array $optionValues = []): Model|Builder
    {
        $wishlist = Wishlist::query()
            ->updateOrCreate([
                'storage_id' => $this->identityStorage->get()
            ], $this->storedData($this->identityStorage->get()));

        $wishlistItem = $wishlist->wishlistItems()->updateOrCreate([
            'product_id' => $product->getKey(),
            'string_option_values' => $this->stringedOptionValues($optionValues)
        ], [
            'price' => $product->price,
            'string_option_values' => $this->stringedOptionValues($optionValues)
        ]);

        $wishlistItem->optionValues()->sync($optionValues);

        $this->forgetCache();

        return $wishlist;
    }

    public function delete(WishlistItem $item): void
    {
        $item->delete();

        $this->forgetCache();
    }

    public function get()
    {
        return Cache::remember($this->cacheKey(), now()->addHour(), function (){
            return Wishlist::query()
                ->with('wishlistItems')
                ->where('storage_id', $this->identityStorage->get())
                ->when(auth()->check(), fn(Builder $query) => $query->orWhere('user_id', auth()->id()))
                ->first() ?? false;
        });
    }

    public function items(): Collection
    {
        if(!$this->get()) {
            return collect([]);
        }

        return WishlistItem::query()
            ->with(['product', 'optionValues.option'])
            ->whereBelongsTo($this->get())
            ->get();
    }

    public function wishlistItems(): Collection
    {
        if(!$this->get()) {
            return collect([]);
        }
        return $this->get()->wishlistItems;
    }
}
