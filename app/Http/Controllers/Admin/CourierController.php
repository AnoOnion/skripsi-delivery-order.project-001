<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{
    Pembayaran, Laporan_kendaraan,
    Transaksi
};

use Carbon\Carbon;

use Illuminate\Support\Str;
use Illuminate\Http\{
    Request, Response
};

class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user    = $request->user('admin');

        $vehicle = Laporan_kendaraan::join('kendaraan', 'laporan_kendaraan.id_kendaraan', '=', 'kendaraan.id')
                                    ->where('laporan_kendaraan.id_admin', $user->id)
                                    ->orderBy('laporan_kendaraan.created_at', 'desc')
                                    ->first();

        if ($vehicle) {
            $vehicle['gambar'] = asset('storage/images/vehicle/' . ($vehicle['gambar'] ?? 'not-found.png'));

            $user->avatar = (
                filter_var($user->avatar, FILTER_VALIDATE_URL) ? $user->avatar : asset(
                    'storage/images/profile/' . $user->avatar
                )
            );

            return response()->json([
                'status'  => 'success',
                'results' => [
                    'user'      => $user,
                    'vehicle'   => $vehicle
                ]
            ]);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'kurir tidak tersedia!'
        ], Response::HTTP_NO_CONTENT);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user   = $request->user('admin');

        $vehicleReport = Laporan_kendaraan::where('id_kendaraan', $request->id_kendaraan)
                                          ->orderBy('created_at', 'desc')
                                          ->first();

        if ($vehicleReport['status'] == 'ada') {
            $vehicleReport = Laporan_kendaraan::create([
                'id_admin'      => $user->id,
                'id_kendaraan'  => $request->id_kendaraan,

                'kode_laporan'  => 'Ken.' . Str::substr(time(), 5, 5),
                'status'        => 'pakai'
            ]);
        }

        $order  = Pembayaran::select('*', 'user.id', 'pembayaran.id as id_pembayaran')
                            ->join('user', 'pembayaran.id_user', '=', 'user.id')
                            ->leftJoin('aset_user', 'user.id', '=', 'aset_user.id_user')
                            ->where('pembayaran.id_admin', $user->id)
                            ->where('pembayaran.status_order', 'aktif')
                            ->where('pembayaran.status_bayar', 'belum')
                            ->where(function ($query) {
                                $query->where('pembayaran.status_kurir', 'process')
                                      ->orWhere('pembayaran.status_kurir', 'delivered');
                            })
                            ->first();

        $activeOrder = null;

        if ($order) {
            $order['saldo'] = $order['saldo'] ?? 0;
            $order['kupon'] = $order['kupon'] ?? 0;

            $order['avatar'] = (
                filter_var($order['avatar'], FILTER_VALIDATE_URL) ? $order['avatar'] : asset(
                    'storage/images/profile/' . $order['avatar']
                )
            );

            $items = Transaksi::select('*', 'transaksi.jumlah')
                              ->join('pembayaran', 'transaksi.id_pembayaran', '=', 'pembayaran.id')
                              ->join('produk', 'transaksi.id_produk', '=', 'produk.id')
                              ->leftJoin('gambar_produk', 'produk.id', '=', 'gambar_produk.id_produk')
                              ->where('transaksi.id_pembayaran', $order['id_pembayaran'])
                              ->groupBy('produk.id')
                              ->get();

            $activeOrder = [
                'user'  => $order,
                'items' => $items->map(function ($value) {
                    $value->path = asset('storage/images/product/' . ($value->path ?? 'not-found.png'));
                    return $value;
                })
            ];
        }

        return response()->json([
            'status'  => 'success',
            'results' => [
                'order'     => $activeOrder,
                'vehicle'   => $vehicleReport
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status_kendaraan'  => 'required',
            'catatan'           => 'nullable|max:200'
        ]);

        $user = $request->user('admin');

        Laporan_kendaraan::create([
            'id_admin'      => $user->id,
            'id_kendaraan'  => $id,

            'kode_laporan'  => 'Ken.' . Str::substr(time(), 5, 5),
            'status'        => $request->status_kendaraan,
            'catatan'       => $request->catatan
        ]);

        return response()->json([
            'status'    => 'success',
            'message'   => 'status kurir sudah berhasil di update'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $user = $request->user('admin');

        $vehicleReport = Laporan_kendaraan::where('status', 'pakai')
                                          ->where('id_admin', $user->id)
                                          ->whereDate('created_at', Carbon::today())
                                          ->first();

        if ($vehicleReport) {
            Laporan_kendaraan::create([
                'id_admin'      => $user->id,
                'id_kendaraan'  => $vehicleReport['id_kendaraan'],

                'kode_laporan'  => $vehicleReport['kode_laporan'],
                'status'        => 'ada'
            ]);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Kurir sudah selesai!'
        ]);
    }
}
