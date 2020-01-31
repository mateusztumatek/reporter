<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PragmaRX\Tracker\Vendor\Laravel\Facade as Tracker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
class WebsiteUser extends Authenticatable
{
    protected $fillable = ['website_id', 'name', 'email', 'session_hash', 'avatar', 'city', 'postal', 'country', 'ip', 'device', 'description', 'status'];
    protected $appends = ['online', 'address'];
    public function getNameAttribute($data){
        return ($data) ? $data : 'Brak danych';
    }
    public function getAddressAttribute(){
        return $this->city.' '.$this->postal.' '.$this->country;
    }
    public function getAvatarAttribute($data){
        if(!$data){
            return 'default/avatar.jpg';
        }else{
            return $data;
        }
    }
    public function getOnlineAttribute(){
        return \Illuminate\Support\Facades\Cache::has('user_online'.$this->id);
    }
    public static function createUser($request){
        $visitor = Tracker::currentSession();
        $geoInfo = geoip('77.252.61.204');
        if($geoInfo){
            $data = ['city' => $geoInfo->city, 'postal' => $geoInfo->postal_code, 'country' => $geoInfo->country, 'ip' => $request->ip(), 'device' => null];
        }else{
            $data = [];
        }
        $data['session_hash'] = Hash::make(Str::random(60));
        $data['website_id'] = $request->website->id;
        $user = WebsiteUser::create($data);
        $request->request->set('website_user', $user);
        Cache::put('user_online'.$user->id, 1, Carbon::now()->addMinutes(3));

    }
    public function chat(){
        return $this->hasOne('App\Chat', 'website_user_id')->where('website_id', $this->website_id);
    }
}
