@extends('layouts.auth')

@section('title', 'Регистрация')

@section('content')
    <x-forms.auth-form title="Регистрация" action="{{ route('register.handle') }}" method="POST">
        @csrf

        <x-forms.text-input
            name="name"
            type="text"
            placeholder="Имя"
            required="true"
            value="{{ old('name') }}"
            :isError="$errors->has('name')"
        />
        @error('name')
        <x-forms.error>
            {{ $message }}
        </x-forms.error>
        @enderror

        <x-forms.text-input
            name="email"
            type="email"
            placeholder="E-mail"
            required="true"
            value="{{ old('email') }}"
            :isError="$errors->has('email')"
        />
        @error('email')
        <x-forms.error>
            {{ $message }}
        </x-forms.error>
        @enderror

        <x-forms.text-input
            name="password"
            type="password"
            placeholder="Пароль"
            required="true"
            :isError="$errors->has('password')"
        />

        @error('password')
        <x-forms.error>
            {{ $message }}
        </x-forms.error>
        @enderror

        <x-forms.text-input
            name="password_confirmation"
            type="password"
            placeholder="Повторите пароль"
            required="true"
            :isError="$errors->has('password_confirmation')"
        />

        @error('password_confirmation')
        <x-forms.error>
            {{ $message }}
        </x-forms.error>
        @enderror

        <x-forms.primary-button>
            Зарегистрироваться
        </x-forms.primary-button>

        <x-slot:socialAuth>
            <ul class="space-y-3 my-3">
                <div class="relative flex py-4 items-center">
                    <div class="flex-grow border-t border-[#bbbbbb]"></div>
                    <span class="flex-shrink mx-2 text-xs text-[#454545]">или войти с помощью</span>
                    <div class="flex-grow border-t border-[#bbbbbb]"></div>
                </div>
                <li>
                    <a href="{{ route('socialite.redirect', ['driver' => 'github']) }}"
                       class="relative flex items-center h-12 px-12 rounded-md bg-red-600 hover:bg-red-600/80 active:bg-white/10 active:translate-y-0.5">
                        <svg class="shrink-0 absolute left-4 w-5 sm:w-6 h-5 sm:h-6" xmlns="http://www.w3.org/2000/svg"
                             fill="white" viewBox="0 0 20 20">
                            <path
                                d="M15.833.833H4.167A4.172 4.172 0 0 0 0 5v10a4.172 4.172 0 0 0 4.167 4.167h11.666A4.172 4.172 0 0 0 20 15V5A4.172 4.172 0 0 0 15.833.833ZM4.167 2.5h11.666a2.5 2.5 0 0 1 2.317 1.572l-6.382 6.383a2.506 2.506 0 0 1-3.536 0L1.85 4.072A2.5 2.5 0 0 1 4.167 2.5Zm11.666 15H4.167a2.5 2.5 0 0 1-2.5-2.5V6.25l5.386 5.383a4.172 4.172 0 0 0 5.894 0l5.386-5.383V15a2.5 2.5 0 0 1-2.5 2.5Z"/>
                        </svg>
                        <span class="grow text-xxs md:text-xs font-bold text-white text-center">Sign in with Google</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('socialite.redirect', ['driver' => 'github']) }}"
                       class="relative flex items-center h-12 px-12 rounded-lg bg-gray hover:bg-gray/80 active:bg-white/10 active:translate-y-0.5">
                        <svg class="shrink-0 absolute left-4 w-5 sm:w-6 h-5 sm:h-6" xmlns="http://www.w3.org/2000/svg"
                             fill="white" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M10 0C4.475 0 0 4.475 0 10a9.994 9.994 0 0 0 6.838 9.488c.5.087.687-.213.687-.476 0-.237-.013-1.024-.013-1.862-2.512.463-3.162-.612-3.362-1.175-.113-.287-.6-1.175-1.025-1.412-.35-.188-.85-.65-.013-.663.788-.013 1.35.725 1.538 1.025.9 1.512 2.337 1.087 2.912.825.088-.65.35-1.088.638-1.338-2.225-.25-4.55-1.112-4.55-4.937 0-1.088.387-1.987 1.025-2.688-.1-.25-.45-1.274.1-2.65 0 0 .837-.262 2.75 1.026a9.28 9.28 0 0 1 2.5-.338c.85 0 1.7.112 2.5.337 1.912-1.3 2.75-1.024 2.75-1.024.55 1.375.2 2.4.1 2.65.637.7 1.025 1.587 1.025 2.687 0 3.838-2.337 4.688-4.562 4.938.362.312.675.912.675 1.85 0 1.337-.013 2.412-.013 2.75 0 .262.188.574.688.474A10.017 10.017 0 0 0 20 10c0-5.525-4.475-10-10-10Z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <span class="grow text-xxs md:text-xs font-bold text-white text-center">Sign in with GitHub</span>
                    </a>
                </li>
            </ul>
        </x-slot:socialAuth>

        <x-slot:links>
            <div class="space-y-3 mt-5">
                <div class="text-xxs md:text-xs">
                    <a href="{{ route('login') }}" class="text-gray hover:text-gray/50">
                        Войти в аккаунт
                    </a>
                </div>
            </div>
        </x-slot:links>

        <x-slot:agreements>
            <ul class="flex flex-col md:flex-row justify-between gap-3 md:gap-4 mt-14 md:mt-12y">
                <li>
                    <a href="#" class="inline-block text-gray hover:text-white/70 text-xxs md:text-xs font-medium"
                       target="_blank" rel="noopener">Пользовательское соглашение</a>
                </li>
                <li class="hidden md:block">
                    <div class="h-full w-[2px] bg-gray/20"></div>
                </li>
                <li>
                    <a href="#" class="inline-block text-gray hover:text-white/70 text-xxs md:text-xs font-medium"
                       target="_blank" rel="noopener">Политика конфиденциальности</a>
                </li>
            </ul>
        </x-slot:agreements>

    </x-forms.auth-form>
@endsection

