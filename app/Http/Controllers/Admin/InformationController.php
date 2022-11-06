<?php

namespace App\Http\Controllers\Admin;

use App\Models\Informasi;
use App\Http\Controllers\Controller;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\{
    Request, Response
};

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $informations = Informasi::select('*', 'informasi.id', 'informasi.created_at', 'informasi.updated_at')
                                 ->join('admin', 'informasi.id_admin', '=', 'admin.id')
                                 ->orderBy('informasi.created_at', 'desc')
                                 ->get();

        return response()->json([
            'status'  => 'success',
            'results' => $informations->map(function ($value) {
                $value->gambar    = asset('storage/images/information/' . ($value->gambar ?? 'not-found.png'));
                $value->deskripsi = Str::limit($value->deskripsi, 100, ' ...');
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
        $this->validate($request, [
            'judul'     => 'required|min:5|max:60|unique:informasi',
            'gambar'    => 'nullable|image:jpeg,png,jpg|max:2048',
            'deskripsi' => 'required|max:1500'
        ]);

        $user = $request->user('admin');

        $informationData = [
            'id_admin'  => $user->id,

            'slug'      => Str::slug($request->judul) . '-' . time(),
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi
        ];

        if ($photo = $request->file('gambar')) {
            $photoName = Str::random(15) . '.' . time() . '.' . $photo->getClientOriginalExtension();

            if ($photo->storeAs('public/images/information', $photoName)) {
                $informationData['gambar'] = $photoName;
            }
        }

        Informasi::create($informationData);

        return response()->json([
            'status'    => 'success',
            'message'   => 'informasi berhasil ditambah!'
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
        $information = Informasi::select('*', 'informasi.id', 'informasi.created_at', 'informasi.updated_at')
                                ->join('admin', 'informasi.id_admin', '=', 'admin.id')
                                ->find($id);

        if ($information) {
            $information['gambar'] = asset(
                'storage/images/information/' . ($information['gambar'] ?? 'not-found.png')
            );

            return response()->json([
                'status'  => 'success',
                'results' => $information
            ]);
        }

        return response()->json([
            'status'  => 'failed',
            'message' => 'informasi tidak tersedia!'
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
            'judul'     => [
                'required', 'min:5', 'max:60', Rule::unique('informasi')->ignore($id)
            ],
            'gambar'    => 'nullable|image:jpeg,png,jpg|max:2048',
            'deskripsi' => 'required|max:1500'
        ]);

        $information = Informasi::find($id);

        if (! $information) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'informasi tidak ditemukan!'
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = $request->user('admin');

        $informationData = [
            'id_admin'  => $user->id,

            'judul'     => $request->judul,
            'gambar'    => $information->gambar,
            'deskripsi' => $request->deskripsi
        ];

        if ($photo = $request->file('gambar')) {
            $photoName = Str::random(15) . '.' . time() . '.' . $photo->getClientOriginalExtension();

            if ($photo->storeAs($path = 'public/images/information', $photoName)) {
                if (
                    ($information->gambar != 'not-found.png') &&
                    Storage::exists($path . '/' . $information->gambar)
                ) {
                    Storage::delete($path . '/' . $information->gambar);
                }

                $informationData['gambar'] = $photoName;
            }
        }

        $information->update($informationData);

        return response()->json([
            'status'    => 'success',
            'message'   => 'informasi berhasil diedit!'
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
        $information = Informasi::find($id);

        if (! $information) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'informasi gagal dihapus!'
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($information['gambar'] != 'not-found.png') {
            if (Storage::exists($path = 'public/images/information/' . $information['gambar'])) {
                Storage::delete($path);
            }
        }

        $information->delete();

        return response()->json([
            'status'    => 'success',
            'message'   => 'informasi berhasil dihapus!'
        ]);
    }
}
