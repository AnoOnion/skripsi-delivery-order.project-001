<?php

namespace App\Http\Controllers\User;

use App\Models\Pembayaran;
use App\Events\BuyerLocation;
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
        $user = $request->user();

        $findPayment = Pembayaran::where('id_user', $user->id)
                                 ->where('status_bayar', 'belum')
                                 ->orderBy('updated_at', 'desc')
                                 ->first();

        $user->avatar = (
            filter_var($user->avatar, FILTER_VALIDATE_URL) ? $user->avatar : asset(
                'storage/images/profile/' . $user->avatar
            )
        );

        if ($findPayment) {
            if ($request->location != null) {
                $findPayment->update([
                    'latitude'       => $request->location['latitude'],
                    'longitude'      => $request->location['longitude'],
                    'alamat_lengkap' => $request->location['alamat_lengkap']
                ]);
            }

            BuyerLocation::dispatch($user, $request->status, $findPayment['id_admin'], $request->location);
        }

        return response()->json([
            'user'     => $user,
            'location' => $request->location
        ]);
    }
}
