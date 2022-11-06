<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\{
    User, Akun_sosial
};

use Carbon\Carbon;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    use AuthenticatesUsers;

    public function signInWithSocial(Request $request, $provider)
    {
        $social    = Socialite::driver($provider)->userFromToken($request->token);

        $checkUser = User::where('email', $social->email)->first();

        if (! $checkUser) {
            switch ($provider) {
                case 'google':
                    $getUser = [
                        'nama_depan'        => $social->user['given_name'],
                        'nama_belakang'     => $social->user['family_name'],
                        'email'             => $social->email,
                        'avatar'            => $social->avatar
                    ];
                    break;

                case 'facebook':
                    $getUser = [
                        'nama_depan'        => $social->name,
                        'email'             => $social->email,
                        'avatar'            => $social->avatar,
                        'jenis_kelamin'     => $social->user['gender'] == 'male' ? 'l' : 'p'
                    ];
                    break;
            }

            $checkUser = User::create([
                ...$getUser, 'email_verified_at' => Carbon::now()->toDateTimeString()
            ]);

            Akun_sosial::create([
                'provider'         => $provider,
                'provider_id_user' => $social->id,
                'id_user'          => $checkUser->id
            ]);
        } else {
            $socialAccount = $checkUser->socialAccounts()->where('provider', $provider)->first();

            if (! $socialAccount) {
                Akun_sosial::create([
                    'provider'         => $provider,
                    'provider_id_user' => $social->id,
                    'id_user'          => $checkUser->id
                ]);
            }
        }

        $token      = (string) $this->guard()->login($checkUser);
        $expiration = $this->guard()->getPayload()->get('exp');

        return response()->json([
            'status'    => 'success',
            'results'   => [
                'token'      => $token,
                'token_type' => 'bearer',
                'expires_in' => $expiration - time()
            ]
        ]);
    }
}
