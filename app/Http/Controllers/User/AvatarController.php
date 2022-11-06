<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\{
    Request, Response
};

class AvatarController extends Controller
{
    public function upload (Request $request)
    {
        $this->validate($request, [
            'photo' => 'required|image:jpeg,png,jpg|max:2048'
        ]);

        if ($photo = $request->file('photo')) {
            $user     = $request->user();
            $fileName = Str::random(15) . '.' . time() . '.' . $photo->getClientOriginalExtension();

            if ($photo->storeAs($path = 'public/images/profile', $fileName)) {
                if (Storage::exists($path . '/' . $user->avatar)) Storage::delete($path . '/' . $user->avatar);

                $user->avatar = $fileName;
                $user->save();

                return response()->json([
                    'status'    => 'success',
                    'message'   => 'profile photo is updated now!'
                ]);
            }

            return response()->json([
                'status'    => 'failed',
                'message'   => 'an error occurred in the system!'
            ], Response::HTTP_FORBIDDEN);
        }
    }
}
