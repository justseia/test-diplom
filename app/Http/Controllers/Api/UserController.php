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
            'aboutMe')->where('id',$id)->first();
        //$user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
         return response()->json($user, 200);
        // return new UserResource($user);
    }
}
