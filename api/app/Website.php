<?php

namespace App;

use App\Services\myModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Website extends myModel
{
    protected $fillable = ['name', 'logo', 'url', 'user_id', 'hash'];
    protected $hidden = ['hash', 'user_id'];
    public function categories(){
        return $this->belongsToMany('App\Category', 'website_categories');
    }
    public function contacts(){
        return $this->hasMany('App\Contact');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function storeValidation(){
        return [
            'name' => 'required',
            'logo' => ['required', function($field, $data, $fail){
                if(!file_exists(storage_path('/app/public/'.$data))) $fail('Plik nie istnieje');
            }],
            'url' => 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
            'hash' => 'required'
        ];
    }
    public function updateValidation(){
        return [
            'name' => 'required',
            'logo' => ['required', function($field, $data, $fail){
                if(!file_exists(storage_path('/app/public/'.$data))) $fail('Plik nie istnieje');
            }],
            'url' => 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
        ];
    }
    public function modifyStoreRequest(Request $request){
        $request->merge(['hash' => Hash::make(Str::random(60))]);
        return $request;
    }
    public function getFillable()
    {
        return $this->fillable;
    }
}
