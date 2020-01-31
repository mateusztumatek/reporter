<?php

namespace App;

use App\Services\myModel;
use Illuminate\Database\Eloquent\Model;

class Category extends myModel
{
    protected $fillable = ['user_id', 'name', 'image', 'description'];
    public function storeValidation(){
        return [
            'name' => 'required'
        ];
    }
    public function updateValidation(){
        return [
            'name' => 'required'
        ];
    }
}
