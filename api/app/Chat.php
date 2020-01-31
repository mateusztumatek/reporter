<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['website_id', 'employee_id', 'website_user_id', 'rabat_code', 'hash', 'last_message'];
    public $appends = ['unseen_count'];
    public function getUnseenCountAttribute(){
        if(request()->website_user){
            return $this->messages()->where('seen', false)->where('type', 'website')->count();
        }else{
            return $this->messages()->where('seen', false)->where('type', 'user')->count();
        }
    }
    public function messages(){
        return $this->hasMany('App\ChatMessage', 'chat_id');
    }
    public function websiteUser(){
        return $this->belongsTo('App\WebsiteUser');
    }
    public function website(){
        return $this->belongsTo('App\Website');
    }
}
