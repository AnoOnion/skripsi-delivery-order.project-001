<?php

namespace App\Http\Controllers\User;

use App\Models\Informasi;
use App\Http\Controllers\Controller;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $informations = Informasi::select('*', 'informasi.created_at', 'informasi.updated_at')
                                 ->join('admin', 'informasi.id_admin', '=', 'admin.id')
                                 ->orderBy('informasi.created_at', 'desc')
                                 ->limit(4)
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
     * Display the specified resource.
     *
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $information = Informasi::select('*', 'informasi.created_at', 'informasi.updated_at')
                                ->join('admin', 'informasi.id_admin', '=', 'admin.id')
                                ->where('informasi.slug', $slug)
                                ->first();

        $information['gambar'] = asset(
            'storage/images/information/' . ($information['gambar'] ?? 'not-found.png')
        );

        return response()->json([
            'status'  => 'success',
            'results' => $information
        ]);
    }
}
