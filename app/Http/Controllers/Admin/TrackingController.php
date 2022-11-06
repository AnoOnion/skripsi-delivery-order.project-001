<?php

namespace App\Http\Controllers\Admin;

use App\Events\CourierLocation;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateLocation (Request $request)
    {
        $user = $request->user('admin');

        $user->avatar = (
            filter_var($user->avatar, FILTER_VALIDATE_URL) ? $user->avatar : asset(
                'storage/images/profile/' . $user->avatar
            )
        );

        event(
            new CourierLocation(
                $user,
                $request->vehicle,
                $request->location
            )
        );

        return response()->json([
            'user'     => $user,
            'vehicle'  => $request->vehicle,
            'location' => $request->location
        ]);
    }
}
