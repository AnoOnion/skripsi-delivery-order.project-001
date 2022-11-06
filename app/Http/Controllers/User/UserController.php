<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\{
    Rule, Rules
};

class UserController extends Controller
{
    public function current (Request $request)
    {
        $user = $request->user();

        $user->avatar = (
            filter_var($user->avatar, FILTER_VALIDATE_URL) ? $user->avatar : asset(
                'storage/images/profile/' . $user->avatar
            )
        );

        return response()->json([
            'user' => $user
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
        $this->validate($request, [
            'nama_depan'    => 'required|min:3',
            'nama_belakang' => 'nullable|min:3',
            'jenis_kelamin' => [
                'nullable', Rule::in(['l', 'p'])
            ],
            'tanggal_lahir' => 'nullable|date',
            'no_telpon'     => 'nullable|numeric|min:8'
        ]);

        $request->user()->fill([
            'nama_depan'    => $request->nama_depan,
            'nama_belakang' => $request->nama_belakang,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_telpon'     => $request->no_telpon
        ])->save();

        return response()->json([
            'status'    => 'success',
            'message'   => 'profil berhasil diperbarui'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'old_password'  => 'required|min:8',
            'new_password'  => ['required', 'confirmed', Rules\Password::defaults()]
        ]);

        $user = $request->user();

        if (Hash::check($request->old_password, $user['password'])) {
            $user->fill([
                'password'  => bcrypt($request->new_password)
            ]);

            $user->save();

            return response()->json([
                'status'    => 'success',
                'message'   => 'password berhasil diperbarui'
            ]);
        }

        return response()->json([
            'status'    => 'failed',
            'message'   => 'password gagal diperbarui'
        ], Response::HTTP_FORBIDDEN);
    }
}
