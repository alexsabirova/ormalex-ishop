<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Events\AfterSessionRegenerated;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Support\Sessions\SessionRegenerator;

class LoginController extends Controller
{
    public function page(): View|Factory|Application
    {
        return view('auth.login');
    }

    public function handle(LoginFormRequest $request): RedirectResponse
    {
        $old = request()->session()->getId();

        if(!auth()->attempt($request->validated())) {
            return back()->withErrors([
                'email' => 'Учетные данные введены неверно.',
            ])->onlyInput('email');
        }

        //SessionRegenerator::run();

        event(
            new AfterSessionRegenerated(
                $old,
                request()->session()->getId()
            )
        );

        return redirect()->intended(route('home'));
    }

    public function logout(): RedirectResponse
    {
        SessionRegenerator::run(fn() => auth()->logout());

        return redirect()->intended(route('home'));
    }
}
