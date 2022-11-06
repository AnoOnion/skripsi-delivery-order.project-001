<?php

namespace App\Http\Controllers\User;

use App\Events\CourierMessage;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Ruang_pesan;

use Illuminate\Http\{
    Request, Response
};
use Illuminate\Database\QueryException;
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
        $user = $request->user();

        $associated = Ruang_pesan::select(
                                    '*', 'admin.id', 'ruang_pesan.id_admin', 'admin.nama_depan', 'admin.nama_belakang', 'admin.avatar',
                                    DB::raw('(select pesan from ruang_pesan where id_admin = admin.id and id_user = user.id order by created_at desc limit 1) as pesan'),
                                    DB::raw('(select pengirim from ruang_pesan where id_admin = admin.id and id_user = user.id order by created_at desc limit 1) as pengirim')
                                 )
                                 ->join('user', 'ruang_pesan.id_user', '=', 'user.id')
                                 ->join('admin', 'ruang_pesan.id_admin', '=', 'admin.id')
                                 ->where('ruang_pesan.id_user', $user->id)
                                 ->groupBy('ruang_pesan.id_admin')
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
            'id_admin'  => 'required|exists:admin,id',
            'pesan'     => 'required|max:200'
        ]);

        $user = $request->user();

        Ruang_pesan::create([
            'id_user'   => $user->id,
            'id_admin'  => $request->id_admin,

            'pengirim'  => 'user',
            'pesan'     => $request->pesan
        ]);

        $user->avatar = (
            filter_var($user->avatar, FILTER_VALIDATE_URL) ? $user->avatar : asset(
                'storage/images/profile/' . $user->avatar
            )
        );

        event(new CourierMessage($request->id_admin, $user, $request->pesan, 'new'));

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
        $user  = $request->user();
        $admin = Admin::find($id);

        $messages = Ruang_pesan::where('id_admin', $id)
                               ->where('id_user', $user->id)
                               ->orderBy('created_at', 'asc')
                               ->get();

        $admin->avatar = (
            filter_var($admin->avatar, FILTER_VALIDATE_URL) ? $admin->avatar : asset(
                'storage/images/profile/' . $admin->avatar
            )
        );

        return response()->json([
            'status'    => 'success',
            'results'   => [
                'user'      => $admin,
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
        $this->validate($request, [
            'id_admin'  => 'required',
            'pesan'     => 'required'
        ]);

        $user = $request->user();

        Ruang_pesan::where('id', $id)
                   ->where('id_user', $user->id)
                   ->update([
                        'pesan' => $request->pesan
                   ]);

        $user->avatar = (
            filter_var($user->avatar, FILTER_VALIDATE_URL) ? $user->avatar : asset(
                'storage/images/profile/' . $user->avatar
            )
        );

        event(new CourierMessage($request->id_admin, $user, $request->pesan, 'modify'));

        return response()->json([
            'status'    => 'success',
            'message'   => 'pesan berhasil diedit!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();

        $chat = Ruang_pesan::where('id', $id)
                           ->where('id_user', $user->id)
                           ->first();

        try {
            $chat->delete();

            $user->avatar = (
                filter_var($user->avatar, FILTER_VALIDATE_URL) ? $user->avatar : asset(
                    'storage/images/profile/' . $user->avatar
                )
            );

            event(new CourierMessage($chat['id_admin'], $user, '', 'remove'));

            return response()->json([
                'status'    => 'success',
                'message'   => 'pesan berhasil dihapus!'
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => 'failed ' . $e->errorInfo
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUser()
    {
        $user = Admin::select(
                        'id', 'email', 'avatar', DB::raw("concat(nama_depan, ' ', nama_belakang) as nama_lengkap")
                    )
                    ->where('level', 'kurir')
                    ->get();

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
