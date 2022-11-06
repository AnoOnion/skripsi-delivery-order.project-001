<?php

namespace App\Http\Controllers\admin;

use App\Events\CreatePaymentStatus;
use App\Events\UpdateProduct;
use App\Http\Controllers\Controller;
use App\Models\{
    Aset_user, Produk, Stok_produk, Pembayaran, Transaksi
};

use PDF;
use Carbon\Carbon;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\{
    Request, Response
};

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user('admin');

        $transactions = Transaksi::select(
                                    '*', 'pembayaran.id', 'pembayaran.jumlah', 'pembayaran.updated_at', 'user.nama_depan as nama_depan', 'user.nama_belakang as nama_belakang', 'admin.nama_depan as nama_depan_kurir', 'admin.nama_belakang as nama_belakang_kurir', 'transaksi.jumlah as jumlah_tx', 'transaksi.total as jumlah_py', 'pembayaran.kode_pembayaran as id_unique_tx', 'produk.kode_item as id_unique_pd', DB::raw('(select SUM(jumlah) from transaksi where id_pembayaran = pembayaran.id) as total_qty')
                                 )
                                 ->join('pembayaran', 'transaksi.id_pembayaran', '=', 'pembayaran.id')
                                 ->join('produk', 'transaksi.id_produk', '=', 'produk.id')
                                 ->join('user', 'pembayaran.id_user', '=', 'user.id')
                                 ->leftJoin('admin', 'pembayaran.id_admin', '=', 'admin.id')
                                 ->where('pembayaran.status_order', 'berhasil')
                                 ->where('pembayaran.status_bayar', 'lunas')
                                 ->whereDate('pembayaran.updated_at', Carbon::today());

        if ($user->level == 'kurir') {
            $transactions->where('pembayaran.id_admin', $user->id);
        }

        $transactions->orderBy('pembayaran.updated_at', 'desc');

        return response()->json([
            'status'    => 'success',
            'results'   => $transactions->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $payment = Pembayaran::where('status_order', 'aktif')
                             ->where('status_bayar', 'belum')
                             ->where('id_user', $request->id)
                             ->orderBy('updated_at', 'desc')
                             ->first();

        if (! $payment) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'user transaksi tidak tersedia'
            ], Response::HTTP_FORBIDDEN);
        }

        $transactions = Transaksi::select('*', 'transaksi.id', 'transaksi.jumlah')
                                 ->join('produk', 'transaksi.id_produk', '=', 'produk.id')
                                 ->where('id_pembayaran', $payment['id'])
                                 ->get();

        if ($request->status_bayar == 'lunas') {
            $this->validate($request, [
                'metode_bayar'      => 'required',
                'pakai_kupon'       => 'nullable',
                'jumlah_tunai'      => [
                    Rule::requiredIf($request->metode_bayar == 'tunai'), 'integer'
                ]
            ]);

            $totalPrice = 0;

            $asset = Aset_user::firstOrCreate([
                'id_user'  => $request->id
            ]);

            foreach ($transactions as $value) {
                $productStock = Stok_produk::where('id_produk', $value->id_produk)
                                           ->orderBy('created_at', 'desc')
                                           ->first();

                if ($value->kupon == 'ya') {
                    $couponTotal = ($asset['kupon'] + $value->jumlah);

                    if ($request->pakai_kupon == 'ya' && $asset['kupon'] >= 10) {
                        $totalDiscount  = floor($asset['kupon']/10);

                        $couponTotal    = (
                            ($asset['kupon'] - ($totalDiscount * 10)) + ($value->jumlah - $totalDiscount)
                        );

                        $totalPrice += $updateTotalPrice = (
                            $value->total - ($totalDiscount * $value->harga)
                        );

                        Transaksi::where('id', $value->id)
                                 ->update([ 'total' => $updateTotalPrice ]);
                    } else {
                        $totalPrice += $value->total;
                    }

                    $asset->update([
                        'kupon'     => $couponTotal
                    ]);
                } else {
                    $totalPrice += $value->total;
                }

                $productStock->update([
                    'stok_akhir' => $productStock['stok_akhir'] - $value->jumlah
                ]);
            }

            $totalCostPayment = ($totalPrice + $payment['jumlah_fee']);

            if ($request->metode_bayar == 'tunai') {
                $cashAmount     = $request->jumlah_tunai;
                $changeAmount   = ($request->jumlah_tunai - $totalCostPayment);
            } else {
                if ($asset['saldo'] < $totalCostPayment) {
                    return response()->json([
                        'status'    => 'success',
                        'message'   => 'saldo tidak mencukupi untuk membayar semua transaksi'
                    ], Response::HTTP_BAD_REQUEST);
                }

                $cashAmount     = 0;
                $changeAmount   = 0;

                $asset->update([
                    'saldo'     => $asset['saldo'] - $totalCostPayment
                ]);
            }

            $payment->update([
                'status_order'      => $request->status_order,
                'status_bayar'      => $request->status_bayar,
                'metode_bayar'      => $request->metode_bayar,
                'jumlah_tunai'      => $cashAmount,
                'jumlah_kembalian'  => $changeAmount
            ]);

            event(new CreatePaymentStatus($request->id, $asset, $request->status_bayar));

            return response()->json([
                'status'    => 'success',
                'message'   => 'transaksi berhasil dibayar'
            ]);
        }

        foreach ($transactions as $value) {
            $productStock = Stok_produk::where('id_produk', $value->id_produk)
                                       ->orderBy('created_at', 'desc')
                                       ->first();

            $productStock->update([
                'stok_sementara' => $productStock['stok_sementara'] + $value->jumlah
            ]);
        }

        Transaksi::where('id_pembayaran', $payment['id'])->delete();

        $payment->update(
            $request->only([ 'status_order', 'status_bayar' ])
        );

        $this->eventUpdateStockProduct();

        event(new CreatePaymentStatus($request->id, null, $request->status_bayar));

        return response()->json([
            'status'    => 'success',
            'message'   => 'transaksi telah digagalkan'
        ]);
    }

    public function report()
    {
        $transactions = Transaksi::select(
                                    '*', 'transaksi.jumlah', 'transaksi.created_at', 'transaksi.updated_at', 'pembayaran.kode_pembayaran as id_unique_tx', 'produk.kode_item as id_unique_pd', 'admin.nama_depan as nama_depan_ad', 'user.nama_depan as nama_depan_us', 'user.nama_belakang as nama_belakang_us'
                                 )
                                 ->join('pembayaran', 'transaksi.id_pembayaran', '=', 'pembayaran.id')
                                 ->join('produk', 'transaksi.id_produk', '=', 'produk.id')
                                 ->join('admin', 'pembayaran.id_admin', '=', 'admin.id')
                                 ->join('user', 'pembayaran.id_user', '=', 'user.id')
                                 ->where('pembayaran.status_order', 'berhasil')
                                 ->where('pembayaran.status_bayar', 'lunas')
                                 ->get();

        return response()->json([
            'status'    => 'success',
            'results'   => $transactions
        ]);
    }

    public function print(Request $request)
    {
        $this->validate($request, [
            'early_period'  => 'required',
            'end_period'    => 'required',
            'courier'       => 'nullable'
        ]);

        $transactions = Transaksi::select(
                                    '*', 'transaksi.jumlah', 'transaksi.created_at', 'transaksi.updated_at', 'pembayaran.kode_pembayaran as id_unique_tx', 'produk.kode_item as id_unique_pd', 'admin.nama_depan as nama_depan_ad', 'user.nama_depan as nama_depan_us', 'user.nama_belakang as nama_belakang_us'
                                 )
                                 ->join('pembayaran', 'transaksi.id_pembayaran', '=', 'pembayaran.id')
                                 ->join('produk', 'transaksi.id_produk', '=', 'produk.id')
                                 ->join('admin', 'pembayaran.id_admin', '=', 'admin.id')
                                 ->join('user', 'pembayaran.id_user', '=', 'user.id')
                                 ->where('pembayaran.status_order', 'berhasil')
                                 ->where('pembayaran.status_bayar', 'lunas')
                                 ->whereBetween('transaksi.created_at', [
                                     $request->early_period, $request->end_period
                                 ]);

        if ($request->courier) {
            $findTransactions = $transactions->where('admin.nama_depan', $request->courier)->get();
        } else {
            $findTransactions = $transactions->get();
        }

        if ($findTransactions->isNotEmpty()) {
            $pdf = PDF::loadView('print/report', [
                'transactions'  => $findTransactions,
                'early_period'  => $request->early_period,
                'end_period'    => $request->end_period
            ]);

            return $pdf->download(
                'laporan-transaksi-' . $request->early_period . '-' . $request->end_period . '.pdf'
            );
        }

        return response()->json([
            'status'    => 'failed',
            'message'   => 'gagal membuat file pdf'
        ], Response::HTTP_BAD_REQUEST);
    }
}
