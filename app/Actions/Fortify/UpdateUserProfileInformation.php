<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'username' => ['required', 'string', 'max:10'],
            'nombres' => ['required', 'string', 'max:20'],
            'apellidos' => ['required', 'string', 'max:20'],
            'dni' => ['required', 'integer', 'digits:8',Rule::unique('users')->ignore($user->id)],
            'edad' => ['required', 'integer', 'digits:2'],
            'ncelular' => ['required', 'integer', 'digits:9'],
            'fnac' => ['required', 'string', 'max:10'],
            'direccion' => ['required', 'string', 'max:30'],
            'sexo' => ['required', 'string', 'max:1'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'username' => $input['username'],
                'email' => $input['email'],
                'nombres' => $input['nombres'],
                'apellidos' => $input['apellidos'],
                'dni' => $input['dni'],
                'fnac' => $input['fnac'],
                'edad' => $input['edad'],
                'sexo' => $input['sexo'],
                'ncelular' => $input['ncelular'],
                'direccion' => $input['direccion']
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'username' => $input['username'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
