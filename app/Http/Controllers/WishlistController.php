<?php

namespace App\Http\Controllers;


use Domain\Product\Models\Product;
use Domain\Wishlist\Models\WishlistItem;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;


class WishlistController extends Controller
{
    public function index(): View
    {
        return view('wishlist.index', [
            'items' => wishlist()->items()
        ]);
    }

    public function add(Product $product): RedirectResponse
    {
        wishlist()->add(
            $product,
            request('options', [])
        );

        return redirect()
            ->intended(route('wishlist'));
    }

    public function delete(WishlistItem $item): RedirectResponse
    {
        wishlist()->delete($item);

        return redirect()
            ->intended(route('wishlist'));
    }
}
