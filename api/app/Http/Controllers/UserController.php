<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function update(Request $request, User $user){
        if(!$user || $user->id != $request->user('api')->id) return response()->json(['message' => 'Nie masz dostępu'], 400);
        if($request->password){
            $request->validate([
                'password' => 'confirmed|min:3'
            ]);
            $request->request->set('password', Hash::make($request->password));
            $request->request->set('last_password_change', Carbon::now());
            $user->update($request->all());
        }
        return response()->json($user);
    }
}
