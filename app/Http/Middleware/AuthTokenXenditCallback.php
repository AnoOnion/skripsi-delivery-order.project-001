<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\{
    Request, Response
};

class AuthTokenXenditCallback
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('x-callback-token') != env('XENDIT_CALLBACK_TOKEN', null)) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'token tidak valid!'
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
