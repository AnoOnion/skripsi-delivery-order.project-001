<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\{
    Aset_user, Pembayaran
};

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user    = $request->user();

        $asset   = Aset_user::where('id_user', $user->id)->first();

        $payment = Pembayaran::select(
                                    '*', DB::raw("(select COUNT(id) from pembayaran pay where pay.id_user = pembayaran.id_user and status_order = 'berhasil') as total_tx")
                             )
                             ->where('id_user', $user->id)
                             ->where('status_bayar', 'belum')
                             ->firstOr(function () use ($user) {
                                    $payment = Pembayaran::create([
                                        'id_user'         => $user->id,
                                        'kode_pembayaran' => 'San.' . $user->id . '/' . Str::random(6),
                                        'status_order'    => 'belum',
                                        'status_kurir'    => 'belum'
                                    ]);

                                    $getTotalTx = Pembayaran::select(DB::raw('COUNT(id) as total_tx'))
                                                            ->where('id_user', $user->id)
                                                            ->where('status_order', 'berhasil')
                                                            ->first();

                                    return [
                                        ...$payment->toArray(),
                                        ...$getTotalTx->toArray()
                                    ];
                             });

        return response()->json([
            'status'  => 'success',
            'results' => [
                'asset'     => $asset,
                'payment'   => $payment
            ]
        ]);
    }
}
