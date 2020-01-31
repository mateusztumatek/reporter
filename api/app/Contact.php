<?php

namespace App;

use App\Services\myModel;
use Illuminate\Database\Eloquent\Model;

class Contact extends myModel
{
    protected $fillable = ['name', 'phone', 'photo', 'email', 'hour_from', 'hour_to', 'description', 'website_id'];
    public function website(){
        return $this->belongsTo('App\Website');
    }
    public function getPhotoAttribute($data){
        if(!$data) return 'default/avatar.jpg';
        return $data;
    }
}
