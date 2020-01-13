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
}
