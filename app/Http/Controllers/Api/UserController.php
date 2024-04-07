<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile($id)
    {
        $user = User::select(
            'id',
            'urlAvatar',
            'name',
            'email',
            'age',
            'medcoins',
            'aboutMe',
            'blocked'
        )->where('id',$id)->first();
        //$user = User::find($id);

        if (!$user) {
            return $this->sendError('User not found',401);
        }
        if ($user->blocked == 1){
            return $this->sendError('User blocked',401);
        }
         return response()->json($user, 200);
    }

    public function medcoins(Request $request)
    {
        if (!empty($request->user_id) && !empty($request->coins)){
            $user = User::find($request->user_id);
            $user->medcoins = $request->coins;
            $user->save();
            return $this->sendResponse('User coins updated',200);
        }else{
            return $this->sendError('User id and coins required',403);
        }
    }
}
