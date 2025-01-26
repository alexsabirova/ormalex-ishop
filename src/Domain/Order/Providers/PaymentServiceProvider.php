<?php

declare(strict_types=1);

namespace Domain\Order\Providers;

use Domain\Auth\Actions\RegisterNewUserAction;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Order\Payment\Gateways\YooKassa;
use Domain\Order\Payment\PaymentData;
use Domain\Order\Payment\PaymentSystem;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        /*PaymentSystem::provider(function () {
            return new YooKassa();
        });*/

        PaymentSystem::onCreating(function (PaymentData $paymentData) {
            return $paymentData;
        });

        PaymentSystem::onSuccess(function (PaymentData $paymentData) {
        });

        PaymentSystem::onError(function (string $message, PaymentData $paymentData) {
        });
    }
}

