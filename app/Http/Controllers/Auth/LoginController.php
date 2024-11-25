<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    public function page(): View|Factory|Application
    {
        return view('auth.login');
    }

    public function handle(LoginFormRequest $request): RedirectResponse
    {
        if(!auth()->attempt($request->validated())) {
            return back()->withErrors([
                'email' => 'Учетные данные введены неверно.',
            ])->onlyInput('email');
        }
        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    public function logout(): RedirectResponse
    {
        auth()->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect()->route('home');
    }
}
