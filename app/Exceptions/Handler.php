<?php

declare(strict_types=1);

namespace App\Exceptions;

use DomainException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->renderable(function (DomainException $e) {
            flash()->alert($e->getMessage());

            return session()->previousUrl()
                ? back()
                : redirect()->route('home');
        });
    }
}
