<?php

namespace App\Http\Controllers;

use Domain\Product\Models\Product;
use Domain\Product\ViewModels\ProductViewModel;
use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;


class ProductController extends Controller
{
    public function __construct(private readonly Session $session)
    {
    }
    public function __invoke(Product $product): View|Factory|Application
    {
        //$product->load(['optionValues.option']);

        //$viewed = session('viewed', []);

        /*if(!empty(session('viewed'))) {
            $viewed = Product::query()
                ->where(function ($q) use ($product) {
                    $q->whereIn('id', session('viewed'))
                        ->where('id', '!=', $product->id);
                })
                ->limit(4)
                ->get();
        }*/

        $this->session->put('viewed_products.' . $product->id, $product->id);

  /*      return view('product.show', [
            'product' => $product,
            'options' => $product->optionValues->keyValues(),
            'viewed' => $viewed,
        ]);*/

        return view('product.show', new ProductViewModel($product));
    }
}
