<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    protected function passwordRules(): array
    {
        return [
            'required',
            'string',
            Password::min(8) // Minimum of 8 characters
            ->mixedCase() // Requires both uppercase and lowercase letters
            ->letters()   // Requires letters
            ->numbers()   // Requires numbers
            ->symbols()   // Requires special characters
        ];
    }
}
