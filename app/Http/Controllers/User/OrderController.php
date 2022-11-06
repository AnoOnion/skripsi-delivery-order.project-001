<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\{
    Produk, Stok_produk, Pembayaran, Transaksi
};

use Illuminate\Database\QueryException;
use Illuminate\Http\{
    Request, Response
};

class OrderController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $total       = 0;
        $productCart = [];

        foreach ($request->items as $value) {
            if ($value['qty'] > 0) {
                $productStock = Stok_produk::where('id_produk', $value['id'])
                                           ->orderBy('created_at', 'desc')
                                           ->first();

                if ($productStock['stok_sementara'] < $value['qty']) {
                    return response()->json([
                        'status'  => 'failed',
                        'message' => 'stok produk dengan jumlah order tidak sesuai!'
                    ]);
                }

                $total += $value['total'];

                $productCart[] = [
                    'id_pembayaran' => $request->payment_id,
                    'id_produk'     => $value['id'],
                    'harga'         => $value['price'],
                    'jumlah'        => $value['qty'],
                    'total'         => $value['total']
                ];
            } else {
                return response()->json([
                    'status'  => 'failed',
                    'message' => 'stok produk dengan jumlah order tidak sesuai!'
                ]);
            }
        }

        foreach ($productCart as $value) {
            $productStock = Stok_produk::where('id_produk', $value['id_produk'])
                                        ->orderBy('created_at', 'desc')
                                        ->first();

            if ($productStock) {
                Transaksi::create($value);

                $productStock->update([
                    'stok_sementara' => $productStock['stok_sementara'] - $value['jumlah']
                ]);
            }
        }

        Pembayaran::where('id', $request->payment_id)->update([
            'status_order'  => 'aktif',
            'status_kurir'  => 'pending',
            'jumlah'        => $total
        ]);

        $this->eventUpdateStockProduct();

        return response()->json([
            'status'  => 'success',
            'message' => 'produk berhasil di order!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $transaction = Transaksi::where('id_pembayaran', $id)->get();

            foreach ($transaction as $value) {
                $productStock = Stok_produk::where('id_produk', $value->id_produk)
                                           ->orderBy('created_at', 'desc')
                                           ->first();

                $productStock->update([
                    'stok_sementara' => $productStock['stok_sementara'] + $value->jumlah
                ]);
            }

            Transaksi::where('id_pembayaran', $id)->delete();

            Pembayaran::where('id', $id)->update([
                'status_order'  => 'batal',
                'status_kurir'  => 'belum',
                'jumlah'        => '0'
            ]);

            $this->eventUpdateStockProduct();

            return response()->json([
                'status'  => 'success',
                'message' => 'order berhasil di batalkan!'
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'failed ' . $e->errorInfo
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
