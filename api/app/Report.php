<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['uuid', 'website_id', 'category_id', 'website_user_id', 'reference_number', 'description', 'attachments', 'admin_comment', 'status'];

    public function website(){
        return $this->belongsTo('App\Website');
    }
    public function website_user(){
        return $this->belongsTo('App\WebsiteUser');
    }
    public function category(){
        return $this->belongsTo('App\Category');
    }
}
