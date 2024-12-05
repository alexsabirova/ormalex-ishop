<?php

namespace App\Http\Controllers;

use Domain\Product\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;


class ProductController extends Controller
{
    public function __invoke(Product $product): View|Factory|Application
    {
        $product->load(['optionValues.option']);

        $viewed = session('viewed', []);

        if(!empty(session('viewed'))) {
            $viewed = Product::query()
                ->where(function ($q) use ($product) {
                    $q->whereIn('id', session('viewed'))
                        ->where('id', '!=', $product->id);
                })
                ->limit(4)
                ->get();
        }

        session()->put('viewed.' . $product->id, $product->id);

        return view('product.show', [
            'product' => $product,
            'options' => $product->optionValues->keyValues(),
            'viewed' => $viewed,
        ]);
    }
}
