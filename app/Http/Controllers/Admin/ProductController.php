<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{
    Produk, Gambar_produk, Stok_produk
};

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\{
    DB, Storage
};
use Illuminate\Http\{
    Request, Response
};

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
                            DB::raw('(select stok_akhir from stok_produk where id_produk = produk.id order by created_at desc limit 1) as stok'),
                            DB::raw('(select harga_jual from stok_produk where id_produk = produk.id order by created_at desc limit 1) as harga')
                          )
                          ->join('admin', 'produk.id_admin', '=', 'admin.id')
                          ->leftJoin('gambar_produk', 'produk.id', '=', 'gambar_produk.id_produk')
                          ->groupBy('produk.id')
                          ->orderBy('produk.created_at', 'desc')
                          ->get();

        return response()->json([
            'status'  => 'success',
            'results' => $products->map(function ($value) {
                $value->path      = asset('storage/images/product/' . ($value->path ?? 'not-found.png'));
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
        $user = $request->user('admin');

        $this->validate($request, [
            'kode_item' => 'required',
            'nama_item' => 'required|min:5|max:50|unique:produk',
            'deskripsi' => 'nullable|max:200',
            'berat'     => 'nullable',
            'volume'    => 'nullable',
            'kupon'     => 'required',
            'gambar.*'  => 'nullable|image:jpeg,png,jpg|max:2048'
        ]);

        try {
            $product = Produk::create([
                'id_admin'  => $user->id,

                'kode_item' => $request->kode_item,
                'nama_item' => $request->nama_item,
                'deskripsi' => $request->deskripsi,
                'berat'     => $request->berat,
                'volume'    => $request->volume,
                'kupon'     => $request->kupon
            ]);

            if ($request->hasfile('gambar')) {
                foreach ($request->file('gambar') as $value) {
                    $fileName = Str::random(15) . '.' . time() . '.' . $value->getClientOriginalExtension();

                    if ($value->storeAs('public/images/product', $fileName)) {
                        Gambar_produk::create([
                            'id_produk' => $product->id,
                            'path'      => $fileName,
                        ]);
                    }
                }
            }

            $this->eventUpdateStockProduct();

            return response()->json([
                'status'    => 'success',
                'message'   => 'produk berhasil ditambah!'
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
        $product = Produk::select(
                            '*', 'produk.id', 'produk.created_at', 'produk.updated_at',
                            DB::raw('(select stok_akhir from stok_produk where id_produk = produk.id order by created_at desc limit 1) as stok'),
                            DB::raw('(select harga_jual from stok_produk where id_produk = produk.id order by created_at desc limit 1) as harga')
                         )
                         ->join('admin', 'produk.id_admin', '=', 'admin.id')
                         ->find($id);

        if (! $product) {
            return response()->json([
                'status'  => 'failed',
                'message' => 'produk tidak tersedia!'
            ], Response::HTTP_NOT_FOUND);
        }

        $productImages = Gambar_produk::where('gambar_produk.id_produk', $id)
                                      ->get();

        $productStock  = Stok_produk::where('id_produk', $id)
                                    ->orderBy('updated_at', 'desc')
                                    ->get();

        if ($productImages->isNotEmpty()) {
            $productImages = $productImages->map(function ($value) {
                $value->path = asset('storage/images/product/' . ($value->path ?? 'not-found.png'));
                return $value;
            });
        } else {
            $productImages = [
                ['path'  => asset('storage/images/product/not-found.png')]
            ];
        }

        return response()->json([
            'status'  => 'success',
            'results' => [
                'detail'    => $product,
                'images'    => $productImages,
                'stock'     => $productStock
            ]
        ]);
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
            'nama_item' => [
                'required', 'min:5', 'max:50', Rule::unique('produk')->ignore($id)
            ],
            'deskripsi' => 'nullable|max:200',
            'berat'     => 'nullable',
            'volume'    => 'nullable',
            'kupon'     => 'required',
            'gambar.*'  => 'nullable|image:jpeg,png,jpg|max:2048'
        ]);

        $product = Produk::find($id);

        if (! $product) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'Produk tidak ditemukan!'
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($request->hasfile('gambar')) {
            $path = 'public/images/product';
            $productImages = Gambar_produk::where('id_produk', $id)->get();

            foreach ($productImages as $value) {
                if (Storage::exists($path . '/' . $value->gambar)) {
                    Storage::delete($path . '/' . $value->gambar);
                }
            }

            Gambar_produk::where('id_produk', $id)->delete();

            foreach ($request->file('gambar') as $value) {
                $fileName = Str::random(15) . '.' . time() . '.' . $value->getClientOriginalExtension();

                if ($value->storeAs($path, $fileName)) {
                    Gambar_produk::create([
                        'id_produk' => $id,
                        'path'      => $fileName,
                    ]);
                }
            }
        }

        $product->update([
            'id_admin'  => $user->id,

            'nama_item' => $request->nama_item,
            'deskripsi' => $request->deskripsi,
            'berat'     => $request->berat,
            'volume'    => $request->volume,
            'kupon'     => $request->kupon
        ]);

        $this->eventUpdateStockProduct();

        return response()->json([
            'status'    => 'success',
            'message'   => 'produk berhasil diedit!'
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
            Produk::where('id', $id)->delete();

            $this->eventUpdateStockProduct();

            return response()->json([
                'status'    => 'success',
                'message'   => 'produk berhasil dihapus!'
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'failed ' . $e->errorInfo
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function status(Request $request, $id)
    {
        $user = $request->user('admin');

        Produk::where('id', $id)->update([
            'id_admin'  => $user->id,
            'status'    => $request->status
        ]);

        $this->eventUpdateStockProduct();

        return response()->json([
            'status'    => 'success',
            'message'   => 'status produk berhasil diubah!'
        ]);
    }

    public function report()
    {
        $products = Stok_produk::select('*', 'stok_produk.created_at', 'stok_produk.updated_at')
                               ->join('produk', 'stok_produk.id_produk', '=', 'produk.id')
                               ->join('admin', 'produk.id_admin', '=', 'admin.id')
                               ->orderBy('stok_produk.created_at', 'desc')
                               ->limit(10)
                               ->get();

        return response()->json([
            'status'  => 'success',
            'results' => $products
        ]);
    }
}
