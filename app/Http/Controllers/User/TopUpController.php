<?php

namespace App\Http\Controllers\User;

use App\Events\CreateTopUpStatus;
use App\Http\Controllers\Controller;
use App\Notifications\User\InvoiceTopUp;
use App\Models\{
    User, Aset_user, Laporan_topup
};

use Illuminate\Support\Str;
use Illuminate\Http\{
    Request, Response
};

use Xendit\Xendit;

class TopUpController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct ()
    {
        Xendit::setApiKey(
            env('XENDIT_API', null)
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $topupHistory = Laporan_topup::where('id_user', $user->id)
                                     ->orderBy('updated_at', 'desc')
                                     ->limit(15)
                                     ->get();

        return response()->json([
            'status'    => 'success',
            'results'   => $topupHistory
        ]);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'jumlah_topup' => 'required|integer'
        ]);

        $user   = $request->user();

        $response = \Xendit\Invoice::create([
            'external_id'           => 'San.' . $user->id . '/Pay/' . Str::random(6),
            'payer_email'           => $user->email,
            'description'           => 'Top Up Saldo San-Qua Karanganyar',
            'amount'                => $request->jumlah_topup,
            'success_redirect_url'  => env('APP_URL') . '/topup/success',
            'failure_redirect_url'  => env('APP_URL') . '/topup/failed'
        ]);

        return response()->json([
            'status'    => 'success',
            'results'   => $response
        ]);
    }

    public function handleCallback($status)
    {
        return view('topup/callback', compact('status'));
    }

    public function callback(Request $request)
    {
        $user = User::where('email', $request->payer_email)->first();

        if (! $user) {
            return response()->json([
                'status'    => 'failed',
                'message'   => ''
            ]);
        }

        Laporan_topup::create([
            'id_user'       => $user->id,
            'kode_external' => $request->external_id,
            'metode'        => $request->payment_method,
            'bank_kode'     => $request->payment_channel,
            'jumlah'        => $request->amount,
            'deskripsi'     => $request->description
        ]);

        $asset = Aset_user::where('id_user', $user->id)->first();

        if ($asset) {
            $asset->update([
                'saldo'     => $amount = $asset['saldo'] + $request->paid_amount
            ]);
        } else {
            Aset_user::create([
                'id_user'   => $user->id,
                'saldo'     => $amount = $request->paid_amount
            ]);
        }

        event(new CreateTopUpStatus($user->id, $amount));

        $user->notify(new InvoiceTopUp($request->paid_amount));

        return response()->json([
            'status'    => 'success',
            'results'   => 'ok'
        ]);
    }
}
