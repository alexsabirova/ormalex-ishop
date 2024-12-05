<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Domain\Auth\Models\User;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Support\Sessions\SessionRegenerator;
use Throwable;

class SocialAuthController extends Controller
{
    public function redirect(string $driver): RedirectResponse
    {
        try{
            return Socialite::driver($driver)->redirect();
        } catch (Throwable $e){
            throw new DomainException("Произошла ошибка или драйвер не поддерживается");
        }
    }

    public function callback(string $driver): RedirectResponse
    {
        if($driver !== 'github') {
            throw new DomainException("Драйвер не поддерживается");
        }

        $socialUser = Socialite::driver($driver)->user();

        $user = User::query()->updateOrCreate([
            $driver . '_id' => $socialUser->getId(),
        ], [
            'name' => $socialUser->getName()
                ?? $socialUser->getId(),
            'email' => $socialUser->getEmail(),
            'password' => Hash::make(str()->random(20)),
        ]);

        auth()->login($user);

        SessionRegenerator::run(fn() => auth()->login($user));

        return redirect()
            ->intended(route('home'));
    }
}
