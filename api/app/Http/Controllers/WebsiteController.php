<?php

namespace App\Http\Controllers;

use App\Website;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index(Request $request){
        $user = $request->user('api');
        $websites = Website::where('user_id', $user->id)->paginate(($request->per_page)? $request->per_page : 10);
        return response()->json($websites);
    }
    public function show(Request $request){
        return response()->json($request->website->load('categories'));
    }
    public function website_user(Request $request){
        return response()->json($request->website_user);
    }
    public function updateUser(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'avatar' => [function($field, $data, $fail){
                if(!file_exists(storage_path('app/public/'.$data))) $fail('Nie ma takiego pliku');
            }]
        ]);
        $request->website_user->update($request->all());
        return response()->json($request->website_user);
    }
}
