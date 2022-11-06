<?php

namespace App\Http\Controllers\User;

use App\Models\Transaksi;
use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user    = $request->user();

        $history = Pembayaran::select([
                                '*', 'pembayaran.id', DB::raw('(select count(*) from transaksi where transaksi.id_pembayaran = pembayaran.id) as jumlah_produk')
                             ])
                             ->join('admin', 'pembayaran.id_admin', '=', 'admin.id')
                             ->where('pembayaran.id_user', $user->id)
                             ->where('pembayaran.status_order', 'berhasil')
                             ->where('pembayaran.status_bayar', 'lunas')
                             ->orderBy('pembayaran.updated_at', 'desc')
                             ->limit(20)
                             ->get();

        $result = [];
        foreach ($history as $value) {
            $product = Transaksi::select('gambar_produk.path')
                                ->join('produk', 'transaksi.id_produk', '=', 'produk.id')
                                ->leftJoin('gambar_produk', 'produk.id', '=', 'gambar_produk.id_produk')
                                ->where('transaksi.id_pembayaran', $value->id)
                                ->groupBy('produk.id')
                                ->get();

            $result[] = [
                ...$value->toArray(), 'thumbnail' => $product->map(function ($value) {
                    return \Thumbnail::src(public_path('storage/images/product/' . ($value->path ?? 'not-found.png'), 'public'))->smartcrop(20, 20)->url();
                })
            ];
        }

        return response()->json([
            'status'    => 'success',
            'results'   => $result
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $user    = $request->user();

        $product = Transaksi::select('*', 'transaksi.jumlah', 'pembayaran.updated_at')
                            ->join('pembayaran', 'transaksi.id_pembayaran', '=', 'pembayaran.id')
                            ->join('produk', 'transaksi.id_produk', '=', 'produk.id')
                            ->leftJoin('gambar_produk', 'produk.id', '=', 'gambar_produk.id_produk')
                            ->where('pembayaran.id', $id)
                            ->where('pembayaran.id_user', $user->id)
                            ->where('pembayaran.status_order', 'berhasil')
                            ->where('pembayaran.status_bayar', 'lunas')
                            ->groupBy('produk.id')
                            ->get();

        return response()->json([
            'status'    => 'success',
            'results'   => $product->map(function ($value) {
                $value->path = asset('storage/images/product/' . ($value->path ?? 'not-found.png'));
                return $value;
            })
        ]);
    }
}
