<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pengeluaran;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\QueryException;

use Illuminate\Http\{
    Request, Response
};
use Illuminate\Validation\Rule;

class SpendingController extends Controller
{
    private $url;
    private $user;
    private $token;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct ()
    {
        $this->url     = 'https://mobilepulsa.net/api/v1/bill/check';
        $this->user    = '089507367801';
        $this->token   = '1795d7eb9a92f4c1179';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user('admin');

        $spending = Pengeluaran::select(['*', 'pengeluaran.id', 'pengeluaran.created_at', 'pengeluaran.updated_at'])
                               ->leftJoin('admin', 'pengeluaran.id_admin', '=', 'admin.id');

        if ($user->level == 'kurir') {
            $spending->where('pengeluaran.id_admin', $user->id);
        }

        return response()->json([
            'status'  => 'success',
            'results' => $spending->get()->map(function ($value) {
                $value->catatan = Str::limit($value->catatan, 100, ' ...');
                return $value;
            })
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user('admin');

        $this->validate($request, [
            'nama'      => 'required|min:4|max:30',
            'catatan'   => 'nullable',
            'status'    => [
                'nullable', Rule::in(['belum', 'terbayar'])
            ],
            'jumlah'    => 'required|integer'
        ]);

        try {
            Pengeluaran::create([
                'id_admin'  => $user->id,

                'nama'      => $request->nama,
                'catatan'   => $request->catatan,
                'status'    => $request->status,
                'jumlah'    => $request->jumlah
            ]);

            return response()->json([
                'status'    => 'success',
                'message'   => 'pengeluaran berhasil ditambah!'
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'failed ' . $e->errorInfo
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $spending = Pengeluaran::select(['*', 'pengeluaran.id', 'pengeluaran.created_at', 'pengeluaran.updated_at'])
                               ->leftJoin('admin', 'pengeluaran.id_admin', '=', 'admin.id')
                               ->find($id);

        if ($spending) {
            return response()->json([
                'status'  => 'success',
                'results' => $spending
            ]);
        }

        return response()->json([
            'status'  => 'failed',
            'message' => 'pengeluaran tidak tersedia!'
        ], Response::HTTP_NOT_FOUND);
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
        $user = $request->user('admin');

        $this->validate($request, [
            'nama'      => 'required|min:4|max:30',
            'catatan'   => 'nullable',
            'status'    => [
                'nullable', Rule::in(['belum', 'terbayar'])
            ],
            'jumlah'    => 'required|integer'
        ]);

        try {
            Pengeluaran::where('id', $id)->update([
                'id_admin'  => $user->id,

                'nama'      => $request->nama,
                'catatan'   => $request->catatan,
                'status'    => $request->status,
                'jumlah'    => $request->jumlah
            ]);

            return response()->json([
                'status'    => 'success',
                'message'   => 'pengeluaran berhasil diedit!'
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'failed ' . $e->errorInfo
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
            Pengeluaran::where('id', $id)->delete();

            return response()->json([
                'status'    => 'success',
                'message'   => 'pengeluaran berhasil dihapus!'
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'failed ' . $e->errorInfo
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Execute in cronjob.
     *
     * @return \Illuminate\Http\Response
     */
    public function bill()
    {
        $timestamp  = microtime();
        $signature  = md5($this->user . $this->token . $timestamp);

        $params     = [
            'commands'  => 'inq-pasca',
            'username'  => $this->user,
            'ref_id'    => $timestamp,
            'sign'      => $signature,
            'code'      => 'PDAMKAB.PEKALONGAN',
            'hp'        => '0502030014'
        ];

        $findBillByMonth = Pengeluaran::where('nama', 'tagihan pdam')
                                      ->whereYear('created_at', Carbon::now()->format('Y'))
                                      ->whereMonth('created_at', Carbon::now()->format('m'))
                                      ->first();

        try {
            if ($findBillByMonth) {
                return response()->json([
                    'status'    => 'success',
                    'messages'  => 'Tagihan sudah ada!'
                ]);
            }

            $response = Http::withHeaders([
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json'
            ])->post($this->url, $params);

            $response->throw();

            $result = $response->object();

            if ($result->data->response_code === '00') {
                Pengeluaran::create([
                    'nama'      => 'tagihan pdam',
                    'catatan'   => 'Tagihan pdam dengan nama ' . $result->data->tr_name . ' di ' . Str::title($result->data->desc->pdam_name),
                    'jumlah'    => $result->data->price
                ]);
            }

            return response()->json([
                'status'    => 'success',
                'messages'  => 'Tagihan sudah lunas!'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'    => 'success',
                'messages'  => $th->getMessage()
            ]);
        }
    }
}
