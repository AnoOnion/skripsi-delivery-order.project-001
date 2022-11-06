<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\{
    Produk, Gambar_produk
};

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Produk::select(
                            '*', 'produk.id', 'produk.created_at', 'produk.updated_at',
                            DB::raw('(select stok_sementara from stok_produk where id_produk = produk.id order by created_at desc limit 1) as stok'),
                            DB::raw('(select harga_jual from stok_produk where id_produk = produk.id order by created_at desc limit 1) as harga')
                          )
                          ->leftJoin('gambar_produk', 'produk.id', '=', 'gambar_produk.id_produk')
                          ->groupBy('produk.id')
                          ->orderBy('produk.created_at', 'desc')
                          ->get();

        return response()->json([
            'status'  => 'success',
            'results' => $products->filter(function ($value) {
                return $value->stok !== null;
            })->map(function ($value) {
                $value->path      = asset('storage/images/product/' . ($value->path ?? 'not-found.png'));
                $value->deskripsi = Str::limit($value->deskripsi, 100, ' ...');
                return $value;
            })
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
        $product = Produk::select('*', 'produk.created_at', 'produk.updated_at')
                         ->leftJoin('stok_produk', 'produk.id', '=', 'stok_produk.id_produk')
                         ->join('admin', 'produk.id_admin', '=', 'admin.id')
                         ->where('produk.status', true)
                         ->find($id);

        if ($product) {
            $productImages = Gambar_produk::join('produk', 'gambar_produk.id_produk', '=', 'produk.id')
                                          ->where('gambar_produk.id_produk', $id)
                                          ->get();

            return response()->json([
                'status'  => 'success',
                'results' => [
                    'detail'    => $product,
                    'images'    => $productImages->map(function ($value) {
                        $value->path = asset('storage/images/product/' . ($value->path ?? 'not-found.png'));
                        return $value;
                    })
                ]
            ]);
        }

        return response()->json([
            'status'  => 'failed',
            'message' => 'produk tidak tersedia!'
        ], Response::HTTP_NOT_FOUND);
    }
}
