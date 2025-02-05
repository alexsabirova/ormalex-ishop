<?php

namespace App\Http\Controllers;

use Domain\Catalog\ViewModels\BrandViewModel;
use Domain\Catalog\ViewModels\CategoryViewModel;
use Domain\Product\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;


class HomeController extends Controller
{
    public function __invoke(): View|Factory|Application
    {
        $categories = CategoryViewModel::make()
            ->homePage();

        $brands = BrandViewModel::make()
            ->homePage();

        $products = Product::query()
            ->homePage()
            ->with('brand')
            ->get();


        return view('index', compact(
            'categories',
            'brands',
            'products'));
    }
}
