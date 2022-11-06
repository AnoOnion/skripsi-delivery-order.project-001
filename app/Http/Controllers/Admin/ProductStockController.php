<?php

namespace App\Http\Controllers\Admin;

use App\Events\UpdateProduct;
use App\Http\Controllers\Controller;
use App\Models\{
    Produk, Stok_produk
};

use Carbon\Carbon;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductStockController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productStock = Stok_produk::where('id_produk', $id)
                                   ->orderBy('created_at', 'desc')
                                   ->first();

        $productStock['akumulasi_stok'] = $productStock ? $productStock['stok_akhir'] : 0;

        return response()->json([
            'status'    => 'success',
            'results'   => $productStock
        ]);
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
        $user = $request->user();

        $this->validate($request, [
            'stok'          => 'required|integer',
            'harga_beli'    => 'required|integer',
            'harga_jual'    => 'required|integer'
        ]);

        $productStock = Stok_produk::where('id_produk', $id)
                                   ->whereDate('created_at', Carbon::today())
                                   ->first();

        if ($productStock) {
            $productStock->update([
                'id_admin'          => $user->id,

                'stok_awal'         => $productStock['stok_awal'] + $request->stok,
                'stok_sementara'    => $productStock['stok_sementara'] + $request->stok,
                'stok_akhir'        => $productStock['stok_akhir'] + $request->stok,
                'harga_beli'        => $request->harga_beli,
                'harga_jual'        => $request->harga_jual
            ]);

            $this->eventUpdateStockProduct();

            return response()->json([
                'status'    => 'success',
                'message'   => 'stok berhasil diperbarui!'
            ]);
        }

        $productStockData = [
            'stok_awal'         => $request->stok,
            'stok_sementara'    => $request->stok,
            'stok_akhir'        => $request->stok,
        ];

        $productStockYesterday = Stok_produk::where('id_produk', $id)
                                            ->whereDay('created_at', '<=', Carbon::yesterday()->day)
                                            ->whereMonth('created_at', Carbon::yesterday()->month)
                                            ->whereYear('created_at', Carbon::yesterday()->year)
                                            ->orderBy('created_at', 'desc')
                                            ->first();

        if ($productStockYesterday) {
            $stockNow = $productStockYesterday['stok_akhir'] + $request->stok;

            $productStockData = [
                'stok_awal'         => $stockNow,
                'stok_sementara'    => $stockNow,
                'stok_akhir'        => $stockNow
            ];
        }

        Stok_produk::create([
            'id_admin'      => $user->id,
            'id_produk'     => $id,

            'harga_beli'    => $request->harga_beli,
            'harga_jual'    => $request->harga_jual,
            ...$productStockData,
        ]);

        $this->eventUpdateStockProduct();

        return response()->json([
            'status'    => 'success',
            'message'   => 'stok berhasil ditambahkan!'
        ]);
    }
}
