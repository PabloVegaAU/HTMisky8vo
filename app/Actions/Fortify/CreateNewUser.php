<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'username' => ['required', 'string', 'max:10'],
            'nombres' => ['required', 'string', 'max:20'],
            'apellidos' => ['required', 'string', 'max:20'],
            'dni' => ['required', 'integer', 'digits:8'],
            'sexo' => ['required', 'string', 'max:1'],
            'edad' => ['required', 'integer', 'digits:2'],
            'ncelular' => ['required', 'integer', 'digits:9'],
            'fnac' => ['required', 'string', 'max:10'],
            'direccion' => ['required', 'string', 'max:30'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        return User::create([
            'username' => $input['username'],
            'email' => $input['email'],
            'nombres' => $input['nombres'],
            'apellidos' => $input['apellidos'],
            'dni' => $input['dni'],
            'fnac' => $input['fnac'],
            'sexo' => $input['sexo'],
            'edad' => $input['edad'],
            'ncelular' => $input['ncelular'],
            'direccion' => $input['direccion'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
