<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\{
    Auth,
    DB, Hash, Validator
};

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Get the response for a successful password reset.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetResponse(Request $request, $response)
    {
        return ['status' => trans($response)];
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        return response()->json([
            'email' => trans($response)
        ], 400);
    }

    public function checkToken(Request $request)
    {
        $validate = Validator::make($request->only(['token', 'email']), [
            'token' => 'required',
            'email' => 'required'
        ]);

        if (! $validate->fails()) {
            $response = DB::table('password_resets')
                          ->where('email', $request->email)
                          ->where('created_at', '>', Carbon::now()->subHours(2))
                          ->first();

            if (Hash::check($request->token, $response->token)) {
                return response()->json([
                    'status' => true
                ]);
            }

            return response()->json([
                'error' => 'tokens have expired'
            ], 401);
        }

        return response()->json([
            'error' => 'parameters do not match'
        ], 400);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('admin');
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }
}
