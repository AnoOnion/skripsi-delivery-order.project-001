<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{
    Kendaraan, Laporan_kendaraan
};

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\{
    Request, Response
};
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicle = Kendaraan::select(
                                '*', 'kendaraan.id', 'kendaraan.created_at', 'kendaraan.updated_at', DB::raw('(select status from laporan_kendaraan where id_kendaraan = kendaraan.id order by created_at desc limit 1) as status')
                            )
                            ->join('admin', 'kendaraan.id_admin', '=', 'admin.id')
                            ->get();

        return response()->json([
            'status'  => 'success',
            'results' => $vehicle->map(function ($value) {
                $value->gambar  = asset('storage/images/vehicle/' . ($value->gambar ?? 'not-found.png'));
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
            'plat_nomer'        => 'required|max:15|unique:kendaraan',
            'nama_merk'         => 'required',
            'volume_bensin'     => 'required',
            'tanggal_berlaku'   => 'nullable',
            'gambar'            => 'nullable|image:jpeg,png,jpg|max:2048'
        ]);

        try {
            $vehicleData = [
                'id_admin'        => $user->id,

                'plat_nomer'      => $request->plat_nomer,
                'nama_merk'       => $request->nama_merk,
                'volume_bensin'   => $request->volume_bensin,
                'tanggal_berlaku' => $request->tanggal_berlaku
            ];

            if ($image = $request->file('gambar')) {
                $fileName = Str::random(15) . '.' . time() . '.' . $image->getClientOriginalExtension();

                if ($image->storeAs('public/images/vehicle', $fileName)) {
                    $vehicleData['gambar'] = $fileName;
                }
            }

            $vehicle = Kendaraan::create($vehicleData);

            Laporan_kendaraan::create([
                'id_admin'      => $user->id,
                'id_kendaraan'  => $vehicle->id,

                'kode_laporan'  => 'Ken.' . Str::substr(time(), 5, 5),
                'status'        => 'ada'
            ]);

            return response()->json([
                'status'    => 'success',
                'message'   => 'kendaraan berhasil ditambah!'
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
        $vehicle = Kendaraan::select(
                                '*', 'kendaraan.id', 'kendaraan.created_at', 'kendaraan.updated_at', DB::raw('(select status from laporan_kendaraan where id_kendaraan = kendaraan.id order by created_at desc limit 1) as status')
                            )
                            ->join('admin', 'kendaraan.id_admin', '=', 'admin.id')
                            ->groupBy('kendaraan.id')
                            ->find($id);

        if ($vehicle) {
            $vehicle['gambar'] = asset(
                'storage/images/vehicle/' . ($vehicle['gambar'] ?? 'not-found.png')
            );

            $vehicleReport = Laporan_kendaraan::join('admin', 'laporan_kendaraan.id_admin', '=', 'admin.id')
                                              ->where('laporan_kendaraan.id_kendaraan', $id)
                                              ->orderBy('laporan_kendaraan.updated_at', 'desc')
                                              ->get();

            return response()->json([
                'status'  => 'success',
                'results' => [
                    'detail'    => $vehicle,
                    'report'    => $vehicleReport
                ]
            ]);
        }

        return response()->json([
            'status'  => 'failed',
            'message' => 'kendaraan tidak tersedia!'
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
        $this->validate($request, [
            'plat_nomer'        => [
                'required', 'max:15', Rule::unique('kendaraan')->ignore($id)
            ],
            'nama_merk'         => 'required',
            'volume_bensin'     => 'required',
            'tanggal_berlaku'   => 'nullable',
            'gambar'            => 'nullable|image:jpeg,png,jpg|max:2048',
            'status'            => 'nullable'
        ]);

        $user = $request->user('admin');

        try {
            $vehicle = Kendaraan::find($id);

            if (! $vehicle) {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => 'Kendaraan tidak ditemukan!'
                ], Response::HTTP_BAD_REQUEST);
            }

            $vehicleData = [
                'id_admin'        => $user->id,

                'plat_nomer'      => $request->plat_nomer,
                'nama_merk'       => $request->nama_merk,
                'volume_bensin'   => $request->volume_bensin,
                'tanggal_berlaku' => $request->tanggal_berlaku
            ];

            if ($image = $request->file('gambar')) {
                $fileName = Str::random(15) . '.' . time() . '.' . $image->getClientOriginalExtension();

                if ($image->storeAs($path = 'public/images/vehicle', $fileName)) {
                    if (
                        ($vehicle->gambar != 'not-found.png') &&
                        Storage::exists($path . '/' . $vehicle->gambar)
                    ) {
                        Storage::delete($path . '/' . $vehicle->gambar);
                    }

                    $vehicleData['gambar'] = $fileName;
                }
            }

            $vehicle->update($vehicleData);

            $vehicleReport = Laporan_kendaraan::where('id_kendaraan', $id)
                                              ->orderBy('created_at', 'desc')
                                              ->first();

            if ($vehicleReport['status'] != $request->status) {
                Laporan_kendaraan::create([
                    'id_admin'      => $user->id,
                    'id_kendaraan'  => $id,

                    'kode_laporan'  => 'Ken.' . Str::substr(time(), 5, 5),
                    'status'        => $request->status
                ]);
            }

            return response()->json([
                'status'    => 'success',
                'message'   => 'kendaraan berhasil diedit!'
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
        $vehicle = Kendaraan::find($id);

        if (! $vehicle) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'kendaraan gagal dihapus!'
            ], Response::HTTP_BAD_REQUEST);
        }

        $findReport = Laporan_kendaraan::where('id_kendaraan', $id)->count();

        if ($findReport > 1) {
            $vehicle->delete();
        } else {
            if ($vehicle['gambar'] != 'not-found.png') {
                if (Storage::exists($path = 'public/images/vehicle/' . $vehicle['gambar'])) {
                    Storage::delete($path);
                }
            }

            Laporan_kendaraan::where('id_kendaraan', $id)->delete();
            $vehicle->forceDelete();
        }

        return response()->json([
            'status'    => 'success',
            'message'   => 'kendaraan berhasil dihapus!'
        ]);
    }

    public function report()
    {
        $vehicle = Laporan_Kendaraan::select('*', 'laporan_kendaraan.created_at', 'laporan_kendaraan.updated_at')
                                    ->join('kendaraan', 'laporan_kendaraan.id_kendaraan', '=', 'kendaraan.id')
                                    ->join('admin', 'laporan_kendaraan.id_admin', '=', 'admin.id')
                                    ->orderBy('laporan_kendaraan.created_at', 'desc')
                                    ->limit(10)
                                    ->get();

        return response()->json([
            'status'  => 'success',
            'results' => $vehicle
        ]);
    }
}
