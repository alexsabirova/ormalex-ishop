<?php

namespace App\Http\Controllers;

use Domain\Catalog\ViewModels\BrandViewModel;
use Domain\Catalog\ViewModels\CategoryViewModel;
use Domain\Product\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;


class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function handle()
    {
        return view('profile.index');
    }
}
