<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{
    Transaksi, Pembayaran, Pengeluaran, User
};

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    private function generateDates(Carbon $startDate, Carbon $endDate, $format = 'Y-m-d')
    {
        $dates = collect();
        $startDate = $startDate->copy();

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $dates->put($date->format($format), 0);
        }

        return $dates;
    }

    public function report(Request $request) {
        $user = $request->user('admin');

        $ordersPerday     = Pembayaran::where('status_bayar', 'lunas')
                                      ->whereDate('updated_at', Carbon::today());

        $ordersPermonth   = Pembayaran::where('status_bayar', 'lunas')
                                      ->whereYear('updated_at', Carbon::now()->year)
                                      ->whereMonth('updated_at', Carbon::now()->month);

        $incomePerday     = Transaksi::join('pembayaran', 'transaksi.id_pembayaran', '=', 'pembayaran.id')
                                      ->where('pembayaran.status_bayar', 'lunas')
                                      ->whereDate('pembayaran.updated_at', Carbon::today());

        $incomePermonth   = Transaksi::join('pembayaran', 'transaksi.id_pembayaran', '=', 'pembayaran.id')
                                      ->where('pembayaran.status_bayar', 'lunas')
                                      ->whereYear('pembayaran.updated_at', Carbon::now()->year)
                                      ->whereMonth('pembayaran.updated_at', Carbon::now()->month);

        $registeredPerson = User::count();

        if ($user->level == 'kurir') {
            $ordersPerday->where('id_admin', $user->id);
            $ordersPermonth->where('id_admin', $user->id);
            $incomePerday->where('id_admin', $user->id);
            $incomePermonth->where('id_admin', $user->id);
        }

        return response()->json([
            'status'    => 'success',
            'results'   => [
                'ordersPerday'      => $ordersPerday->count(),
                'ordersPermonth'    => $ordersPermonth->count(),
                'incomePerday'      => $incomePerday->sum('total'),
                'incomePermonth'    => $incomePermonth->sum('total'),
                'registeredPerson'  => $registeredPerson
            ]
        ]);
    }

    public function purchase(Request $request) {
        $user   = $request->user('admin');

        $start  = Carbon::today()->subDays(7);
        $end    = Carbon::yesterday();

        $transactions = Transaksi::select(
                                    DB::raw('SUM(transaksi.jumlah) as total, DATE(pembayaran.updated_at) as date')
                                )
                                ->join('pembayaran', 'transaksi.id_pembayaran', '=', 'pembayaran.id')
                                ->where('pembayaran.status_bayar', 'lunas')
                                ->groupBy('date')
                                ->orderBy('transaksi.created_at', 'desc')
                                ->limit(6);

        if ($user->level == 'kurir') {
            $transactions->where('pembayaran.id_admin', $user->id);
        }

        $transactions = $transactions->get()->pluck('total', 'date');

        $dates = $this->generateDates($start, $end);

        return response()->json([
            'status'    => 'success',
            'results'   => $dates->merge($transactions)
        ]);
    }

    public function incomeExpense(Request $request) {
        $user   = $request->user('admin');

        $start  = Carbon::today()->subDays(7);
        $end    = Carbon::yesterday();

        $income = Transaksi::join('pembayaran', 'transaksi.id_pembayaran', '=', 'pembayaran.id')
                              ->select(
                                    DB::raw('SUM(transaksi.total) as total, DATE(pembayaran.updated_at) as date')
                              )
                              ->where('pembayaran.status_bayar', 'lunas')
                              ->groupBy('date')
                              ->orderBy('pembayaran.updated_at', 'desc')
                              ->limit(6);

        // $spending = Pengeluaran::select(
        //                             DB::raw('SUM(jumlah) as total, DATE(updated_at) as date')
        //                         )
        //                        ->where('status', 'terbayar')
        //                        ->groupBy('date')
        //                        ->orderBy('updated_at', 'desc')
        //                        ->limit(6);

        if ($user->level == 'kurir') {
            $income->where('id_admin', $user->id);
            // $spending->where('id_admin', $user->id);
        }

        $income = $income->get()->pluck('total', 'date');

        $dates = $this->generateDates($start, $end);

        return response()->json([
            'status'    => 'success',
            'results'   => [
                'income'    => $dates->merge($income),
                // 'spending'  => $spending->get()
            ]
        ]);
    }
}
