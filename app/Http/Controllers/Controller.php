<?php

namespace App\Http\Controllers;

use App\Events\{
    UpdateProduct, UpdateProductForAdmin
};
use App\Models\Produk;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function eventUpdateStockProduct()
    {
        $products = Produk::select(
                            '*', 'produk.id', 'produk.created_at', 'produk.updated_at',
                            DB::raw('(select stok_sementara from stok_produk where id_produk = produk.id order by created_at desc limit 1) as stok'),
                            DB::raw('(select harga_jual from stok_produk where id_produk = produk.id order by created_at desc limit 1) as harga')
                          )
                          ->join('admin', 'produk.id_admin', '=', 'admin.id')
                          ->leftJoin('gambar_produk', 'produk.id', '=', 'gambar_produk.id_produk')
                          ->groupBy('produk.id')
                          ->orderBy('produk.created_at', 'desc')
                          ->get();

        $productMaps = $products->map(function ($value) {
                            $value->path      = asset('storage/images/product/' . ($value->path ?? 'not-found.png'));
                            $value->deskripsi = Str::limit($value->deskripsi, 100, ' ...');
                            return $value;
                       });

        event(
            new UpdateProduct(
                $productMaps->filter(function ($value) {
                    return $value->stok !== null;
                })->toArray()
            )
        );

        event(
            new UpdateProductForAdmin(
                $productMaps->toArray()
            )
        );
    }
}
