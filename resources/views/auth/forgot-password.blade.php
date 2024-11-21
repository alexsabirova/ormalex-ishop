@extends('layouts.auth')

@section('title', 'Сброс пароля')

@section('content')
    <x-forms.auth
        title="Забыли пароль"
        action="{{ route('forgot-password') }}"
        method="POST"
    >
        @csrf

        <x-forms.text-input
            name="email"
            type="email"
            placeholder="E-mail"
            required="true"
            value=""
            :isError="$errors->has('email')"
        />

        @error('email')
        <x-forms.error>
            {{ $message }}
        </x-forms.error>
        @enderror

        <x-forms.primary-button>
            Отправить
        </x-forms.primary-button>

        <x-slot:socialAuth></x-slot:socialAuth>

        <x-slot:links>
            <div class="space-y-3 mt-5">
                <div class="text-xxs md:text-xs"><a href="{{ route('login') }}" class="text-white hover:text-white/70 font-bold">Вспомнили пароль?</a>
                </div>
            </div>
        </x-slot:links>

        <x-slot:agreements></x-slot:agreements>

    </x-forms.auth>
@endsection
