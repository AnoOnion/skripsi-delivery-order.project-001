<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\{
    Request, Response
};

class ReCaptchaGoogle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $checkReCaptcha = Http::get(
            'https://www.google.com/recaptcha/api/siteverify?secret=' . env('RECAPTCHA_SECRET', null) . '&response=' . $request->header('g-recaptcha-response')
        )->object();

        if ($checkReCaptcha->success === false) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'maaf, sistem kami mendeteksi anda robot!'
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
