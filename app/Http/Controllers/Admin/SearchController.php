<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{
    Produk, Kendaraan, Laporan_kendaraan, Transaksi
};
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\{
    Request, Response
};

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user('admin');

        $findProduct = Produk::select(
                                '*', 'produk.id', 'produk.created_at', 'produk.updated_at',
                                DB::raw('(select stok_akhir from stok_produk where id_produk = produk.id order by created_at desc limit 1) as stok'),
                                DB::raw('(select harga_jual from stok_produk where id_produk = produk.id order by created_at desc limit 1) as harga')
                             )
                             ->join('admin', 'produk.id_admin', '=', 'admin.id')
                             ->leftJoin('gambar_produk', 'produk.id', '=', 'gambar_produk.id_produk')
                             ->where('produk.kode_item', 'like', '%' . $request->input('query') . '%')
                             ->orWhere('produk.nama_item', 'like', '%' . $request->input('query') . '%')
                             ->groupBy('produk.id')
                             ->orderBy('produk.created_at', 'desc')
                             ->get();

        if ($findProduct->isNotEmpty()) {
            return response()->json([
                'status'    => 'success',
                'type'      => 'product',
                'results'   => $findProduct->map(function ($value) {
                    $value->path      = asset('storage/images/product/' . ($value->path ?? 'not-found.png'));
                    $value->deskripsi = Str::limit($value->deskripsi, 100, ' ...');
                    return $value;
                })
            ]);
        }

        $findVehicle = Kendaraan::select(
                                    '*', 'kendaraan.id', 'kendaraan.created_at', 'kendaraan.updated_at', DB::raw('(select status from laporan_kendaraan where id_kendaraan = kendaraan.id order by created_at desc limit 1) as status')
                                )
                                ->join('admin', 'kendaraan.id_admin', '=', 'admin.id')
                                ->where('kendaraan.plat_nomer', 'like', '%' . $request->input('query') . '%')
                                ->orWhere('kendaraan.nama_merk', 'like', '%' . $request->input('query') . '%')
                                ->get();

        if ($findVehicle->isNotEmpty()) {
            return response()->json([
                'status'    => 'success',
                'type'      => 'vehicle',
                'results'   => $findVehicle->map(function ($value) {
                    $value->gambar  = asset('storage/images/vehicle/' . ($value->gambar ?? 'not-found.png'));
                    $value->catatan = Str::limit($value->catatan, 100, ' ...');
                    return $value;
                })
            ]);
        }

        $transactions = Transaksi::select(
                                        '*', 'pembayaran.id', 'pembayaran.jumlah', 'pembayaran.updated_at', 'user.nama_depan as nama_depan', 'user.nama_belakang as nama_belakang', 'admin.nama_depan as nama_depan_kurir', 'admin.nama_belakang as nama_belakang_kurir', 'transaksi.jumlah as jumlah_tx', 'pembayaran.jumlah as jumlah_py', 'pembayaran.id_unique as id_unique_tx', 'produk.id_unique as id_unique_pd', DB::raw('(select SUM(jumlah) from transaksi where id_pembayaran = pembayaran.id) as total_qty')
                                 )
                                 ->join('pembayaran', 'transaksi.id_pembayaran', '=', 'pembayaran.id')
                                 ->join('produk', 'transaksi.id_produk', '=', 'produk.id')
                                 ->join('user', 'pembayaran.id_user', '=', 'user.id')
                                 ->leftJoin('admin', 'pembayaran.id_admin', '=', 'admin.id')
                                 ->where('pembayaran.status_order', 'berhasil')
                                 ->where('pembayaran.status_bayar', 'lunas')
                                 ->whereDate('pembayaran.updated_at', Carbon::today())
                                 ->where('pembayaran.kode_pembayaran', 'like', '%' . $request->input('query') . '%')
                                 ->where('status_order', 'berhasil')
                                 ->where('status_bayar', 'lunas');

        if ($user->level == 'kurir') {
            $findTransaction = $transactions->where('pembayaran.id_admin', $user->id)->get();
        } else {
            $findTransaction = $transactions->orderBy('pembayaran.updated_at', 'desc')->get();
        }

        if ($findTransaction->isNotEmpty()) {
            return response()->json([
                'status'    => 'success',
                'type'      => 'transaction',
                'results'   => $findTransaction
            ]);
        }

        if ($user->level == 'admin') {
            $findVehicleReport = Laporan_kendaraan::join('kendaraan', 'laporan_kendaraan.id_kendaraan', '=', 'kendaraan.id')
                                                ->where('laporan_kendaraan.kode_laporan', 'like', '%' . $request->input('query') . '%')
                                                ->get();

            if ($findVehicleReport->isNotEmpty()) {
                return response()->json([
                    'status'    => 'success',
                    'type'      => 'report/vehicle',
                    'results'   => $findVehicleReport
                ]);
            }
        }

        return response()->json([
            'status'    => 'failed',
            'message'   => 'hasil query tidak ditemukan!'
        ], Response::HTTP_NOT_FOUND);
    }
}
