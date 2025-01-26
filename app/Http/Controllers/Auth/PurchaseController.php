<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Domain\Catalog\ViewModels\BrandViewModel;
use Domain\Catalog\ViewModels\CategoryViewModel;
use Domain\Order\Payment\PaymentData;
use Domain\Order\Payment\PaymentSystem;
use Domain\Product\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Redirector;


class PurchaseController extends Controller
{
    public function index(): Application|Redirector|RedirectResponse
    {
        return redirect(
            PaymentSystem::create(new PaymentData())
                ->url());
    }

    public function callback(): JsonResource
    {
        return PaymentSystem::validate()
            ->response();
    }
}
