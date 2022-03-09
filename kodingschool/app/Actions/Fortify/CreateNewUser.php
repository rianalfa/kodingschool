<?php

namespace App\Actions\Fortify;

use App\Models\Planner;
use App\Models\User;
use App\Models\UserDetail;
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
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:25', 'unique:users', 'alpha_num'],
            'email' => ['required', 'string', 'email', 'max:255', 'ends_with:@stis.ac.id', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'username' => $input['username'],
            'password' => Hash::make($input['password']),
            'last_seen' => date('Y-m-d'),
        ]);

        $user->assignRole('user');

        UserDetail::create([
            'user_id' => $user->id,
            'level_id' => 1,
            'point' => 0,
        ]);

        $planner = Planner::create([
            'user_id' => $user->id,
        ]);

        return $user;
    }
}
