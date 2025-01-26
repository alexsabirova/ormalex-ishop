<?php

namespace Domain\Order\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;
use Illuminate\Translation\PotentiallyTranslatedString;

class PhoneRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match("/^(?:\+7|7|8)+\d{10}$/", Str::phoneNumber($value))) {
            $fail('phone_auth::phone_auth.validation.phone_format"');
        };
    }

    public function passes($attribute, $value): bool
    {
        return is_numeric($value);
    }

    public function message(): string
    {
        return 'Введите телефон только цифры без знаков';
    }
}
