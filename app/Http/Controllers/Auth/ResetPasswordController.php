<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordFormRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function page(string $token): View|Factory|Application
    {
        return view('auth.reset-password', [
            'token' => $token,
        ]);
    }

    public function handle(ResetPasswordFormRequest $request): RedirectResponse
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->setRememberToken(Str()->random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            flash()->info(__($status));

            return redirect()->route('login');
        }

        return back()->withErrors(['email' => __($status)]);
    }
}