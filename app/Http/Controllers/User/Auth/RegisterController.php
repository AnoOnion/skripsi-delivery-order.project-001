<?php

namespace App\Http\Controllers\User\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    protected function registered (Request $request, User $user)
    {
        if ($user instanceof MustVerifyEmail) {
            return response()->json([
                'status' => trans('verification.sent')
            ]);
        }

        return response()->json($user);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator (array $data)
    {
        return Validator::make($data, [
            'nama_depan'    => ['required', 'max:20'],
            'nama_belakang' => ['nullable', 'max:20'],
            'email'         => ['required', 'email:rfc,dns', 'max:40', 'unique:user'],
            'password'      => ['required', 'confirmed', Rules\Password::defaults()]
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create (array $data)
    {
        return User::create([
            'nama_depan'    => $data['nama_depan'],
            'nama_belakang' => $data['nama_belakang'] ?? null,
            'email'         => $data['email'],
            'password'      => bcrypt($data['password'])
        ]);
    }
}
