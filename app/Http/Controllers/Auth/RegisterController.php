<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterFormRequest;
use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class RegisterController extends Controller
{
    public function page(): View|Factory|Application
    {
        return view('auth.register');
    }

    public function handle(RegisterFormRequest $request, RegisterNewUserContract $action): RedirectResponse
    {
        // try/catch
        $action(NewUserDTO::fromRequest($request));

        return redirect()
            ->intended(route('home'));
    }
}
