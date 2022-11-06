<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{
    Transaksi, Pembayaran, Stok_produk
};

use App\Events\CreateOrderStatus;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $items = Transaksi::select('*', 'transaksi.jumlah')
                          ->join('pembayaran', 'transaksi.id_pembayaran', '=', 'pembayaran.id')
                          ->join('produk', 'transaksi.id_produk', '=', 'produk.id')
                          ->leftJoin('gambar_produk', 'produk.id', '=', 'gambar_produk.id_produk')
                          ->where('pembayaran.id_user', $id)
                          ->where('pembayaran.status_order', 'aktif')
                          ->where('pembayaran.status_bayar', 'belum')
                          ->groupBy('produk.id')
                          ->get();

        return response()->json([
            'status'  => 'success',
            'results' => $items->map(function ($value) {
                $value->path = asset('storage/images/product/' . ($value->path ?? 'not-found.png'));
                return $value;
            })
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function orderStatus(Request $request)
    {
        $user    = $request->user('admin');

        $payment = Pembayaran::where('status_order', 'aktif')
                             ->where('status_bayar', 'belum')
                             ->where('id_user', $request->id)
                             ->orderBy('updated_at', 'desc')
                             ->first();

        if ($payment) {
            if (
                ($payment['status_kurir'] == 'process' || $payment['status_kurir'] == 'delivered') &&
                ($payment['id_admin'] != $user->id)
            ) {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => 'pesanan sudah diambil kurir lain!'
                ], Response::HTTP_FORBIDDEN);
            }

            if ($request->status_order == 'batal') {
                $transaction = Transaksi::where('id_pembayaran', $payment['id'])->get();

                foreach ($transaction as $value) {
                    $productStock = Stok_produk::where('id_produk', $value->id_produk)
                                               ->orderBy('created_at', 'desc')
                                               ->first();

                    $productStock->update([
                        'stok_sementara' => $productStock['stok_sementara'] + $value->jumlah
                    ]);
                }

                Transaksi::where('id_pembayaran', $payment['id'])->delete();

                $this->eventUpdateStockProduct();
            }

            $payment->update([
                'id_admin'      => $user->id,
                'status_order'  => $request->status_order,
                'status_kurir'  => $request->status_kurir,
                'jumlah_fee'    => $request->jumlah_fee
            ]);

            event(new CreateOrderStatus(
                $request->id, $request->courier, $request->jumlah_fee, ($request->status_order == 'aktif'), $request->status_kurir
            ));
        }

        $buyer = Pembayaran::select('*', 'user.id')
                           ->join('user', 'pembayaran.id_user', '=', 'user.id')
                           ->leftJoin('aset_user', 'user.id', '=', 'aset_user.id_user')
                           ->where('pembayaran.id_user', $request->id)
                           ->orderBy('pembayaran.updated_at', 'desc')
                           ->first();

        $buyer['saldo'] = $buyer['saldo'] ?? 0;
        $buyer['kupon'] = $buyer['kupon'] ?? 0;

        return response()->json([
            'status'    => 'success',
            'results'   => $buyer
        ]);
    }
}
