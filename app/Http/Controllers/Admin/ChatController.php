<?php

namespace App\Http\Controllers\Admin;

use App\Events\BuyerMessage;
use App\Http\Controllers\Controller;
use App\Models\Ruang_pesan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user('admin');

        $associated = Ruang_pesan::select(
                                    '*', 'user.id', 'ruang_pesan.id_user', 'user.nama_depan', 'user.nama_belakang', 'user.avatar',
                                    DB::raw('(select pesan from ruang_pesan where id_user = user.id and id_admin = admin.id order by created_at desc limit 1) as pesan'),
                                    DB::raw('(select pengirim from ruang_pesan where id_user = user.id and id_admin = admin.id order by created_at desc limit 1) as pengirim')
                                 )
                                 ->join('user', 'ruang_pesan.id_user', '=', 'user.id')
                                 ->join('admin', 'ruang_pesan.id_admin', '=', 'admin.id')
                                 ->where('ruang_pesan.id_admin', $user->id)
                                 ->groupBy('ruang_pesan.id_user')
                                 ->orderBy('ruang_pesan.created_at', 'desc')
                                 ->get();

        return response()->json([
            'status'    => 'success',
            'results'   => $associated->map(function ($value) {
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
            'id_user'   => 'required|exists:user,id',
            'pesan'     => 'required|max:200'
        ]);

        $user = $request->user('admin');

        Ruang_pesan::create([
            'id_user'   => $request->id_user,
            'id_admin'  => $user->id,

            'pengirim'  => 'admin',
            'pesan'     => $request->pesan
        ]);

        $user->avatar = (
            filter_var($user->avatar, FILTER_VALIDATE_URL) ? $user->avatar : asset(
                'storage/images/profile/' . $user->avatar
            )
        );

        event(new BuyerMessage($request->id_user, $user, $request->pesan, 'new'));

        return response()->json([
            'status'    => 'success',
            'message'   => 'pesan berhasil dikirim!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user  = User::find($id);
        $admin = $request->user('admin');

        $messages = Ruang_pesan::where('id_user', $id)
                               ->where('id_admin', $admin->id)
                               ->orderBy('created_at', 'asc')
                               ->get();

        $user->avatar = (
            filter_var($user->avatar, FILTER_VALIDATE_URL) ? $user->avatar : asset(
                'storage/images/profile/' . $user->avatar
            )
        );

        return response()->json([
            'status'    => 'success',
            'results'   => [
                'user'      => $user,
                'messages'  => $messages
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUser()
    {
        $user = User::select(
                        'id', 'email', 'avatar', DB::raw("concat(nama_depan, ' ', nama_belakang) as nama_lengkap")
                    )->get();

        return response()->json([
            'status'    => 'success',
            'results'   => $user->map(function ($value) {
                $value->avatar = (
                    filter_var($value->avatar, FILTER_VALIDATE_URL) ? $value->avatar : asset(
                        'storage/images/profile/' . $value->avatar
                    )
                );

                return $value;
            })
        ]);
    }
}
