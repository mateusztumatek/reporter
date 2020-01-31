<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;
use Psy\Util\Str;

class ReportController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'website' => 'required',
            'website_user' => 'required',
            'category_id' => 'required',
            'description' => 'required',
        ]);
        $request->request->set('website_id', $request->website['id']);
        $check = false;
        while (!$check){
            $uuid = \Illuminate\Support\Str::random('3').rand(10000, 99999);
            if(!Report::where('uuid', $uuid)->first()) $check = true;
        }
        $request->request->set('uuid', $uuid);
        $request->request->set('website_user_id', $request->website_user['id']);
        if($request->attachments){
            $request->request->set('attachments', json_encode($request->attachemnts));
        }
        $report = Report::create($request->except('website', 'website_user'));
        return response()->json($report->load('category'));
    }
}
