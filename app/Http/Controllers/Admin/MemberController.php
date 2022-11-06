<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Illuminate\Validation\{
    Rules, Rule
};
use Illuminate\Http\{
    Request, Response
};

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'status'  => 'success',
            'results' => Admin::get()->map(function ($value) {
                $value->avatar = (
                    filter_var($value->avatar, FILTER_VALIDATE_URL) ? $value->avatar : asset(
                        'storage/images/profile/' . $value->avatar
                    )
                );

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
            'nama_depan'    => 'required|max:40',
            'nama_belakang' => 'nullable',
            'email'         => 'required|email:rfc,dns|max:40|unique:admin',
            'password'      => [
                'required', 'confirmed', Rules\Password::defaults()
            ],
            'gambar'        => 'nullable|image:jpeg,png,jpg|max:2048',
            'jenis_kelamin' => 'nullable',
            'tanggal_lahir' => 'nullable|date'
        ]);

        $fileName = 'https://www.gravatar.com/avatar/1667f76cd188f63e4c39792bb4357838?d=mm&s=40';

        if ($photo = $request->file('gambar')) {
            $fileName = Str::random(15) . '.' . time() . '.' . $photo->getClientOriginalExtension();

            if (! $photo->storeAs('public/images/profile', $fileName)) {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => 'an error occurred in the system!'
                ], Response::HTTP_FORBIDDEN);
            }
        }

        try {
            Admin::create([
                'nama_depan'    => $request->nama_depan,
                'nama_belakang' => $request->nama_belakang,
                'email'         => $request->email,
                'password'      => bcrypt($request->password),
                'avatar'        => $fileName,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir
            ]);

            return response()->json([
                'status'    => 'success',
                'message'   => 'admin berhasil ditambah!'
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
        $admin = Admin::find($id);

        return response()->json([
            'status'  => 'success',
            'results' => $admin
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
        $this->validate($request, [
            'nama_depan'    => 'required|max:40',
            'nama_belakang' => 'nullable',
            'email'         => [
                'required', 'email:rfc,dns', 'max:40', Rule::unique('admin')->ignore($id)
            ],
            'password'      => [
                'nullable', 'confirmed', Rules\Password::defaults()
            ],
            'jenis_kelamin' => 'nullable',
            'tanggal_lahir' => 'nullable|date'
        ]);

        try {
            $params = [
                'nama_depan'    => $request->nama_depan,
                'nama_belakang' => $request->nama_belakang,
                'email'         => $request->email,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir
            ];

            if ($request->password) {
                $params['password'] = bcrypt($request->password);
            }

            Admin::where('id', $id)->update($params);

            return response()->json([
                'status'    => 'success',
                'message'   => 'admin berhasil diedit!'
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
        $admin = Admin::find($id);

        if (! $admin) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'admin gagal dihapus!'
            ], Response::HTTP_BAD_REQUEST);
        }

        Admin::where('id', $id)->delete();

        return response()->json([
            'status'    => 'success',
            'message'   => 'admin berhasil dihapus!'
        ]);
    }
}
