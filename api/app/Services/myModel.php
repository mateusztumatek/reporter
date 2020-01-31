<?php
namespace App\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;

class myModel extends Model{
    public function hasFillable($name){
        return array_search($name, $this->fillable) != false;
    }
    public function scopeOwner($q){
        if($this->hasFillable('user_id')){
            $q->where('user_id', request()->user('api')->id);
        }
        if($this->hasFillable('website_id')){
            $q->whereHas('website', function ($qw){
                $qw->where('user_id', request()->user('api')->id);
            });
        }
        return $q;
    }
    public function scopeFilter($q){
        $inputs = request()->all();
        foreach ($inputs as $key => $input){
            if($key != 'orderBy' && $key != 'orderType'){
                if(Schema::hasColumn(parent::getTable(), $key)){
                    if($input != null && $input != ''){
                        if($input[0] == '%' && $input[strlen($input) - 1] == '%'){
                            $in = substr($input, 1, 1);
                            $in = substr($in, strlen($in), -1);
                            $q->where($key, 'LIKE', '%'.$input.'%');
                        }else{
                            if($input[0] == '!' && $input[strlen($input) -1] == '!'){
                                $in = substr($input, 1, strlen($input) -2);
                                $q->where($key, '!=', $in);
                            }else{
                                $q->where($key, $input);
                            }
                        }
                    }
                }
            }
        }
        if(array_key_exists('orderBy', $inputs)){
            (array_key_exists('orderType', $inputs))? $type = $inputs['orderType'] : $type = 'desc';
            if(Schema::hasColumn(parent::getTable(), $inputs['orderBy'])){
                $q->orderBy($inputs['orderBy'], $type);
            }
        }
        if(array_key_exists('range', $inputs) && is_array($inputs['range'])){
            $date_first = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($inputs['range'][0]), 'UTC')->setTimeZone('Europe/Zurich');
            $date_second = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($inputs['range'][1]), 'UTC')->setTimeZone('Europe/Zurich')->setHours(23)->setMinutes(59);
            $q->where('created_at', '>=', $date_first)->where('created_at', '<=', $date_second);
        }
        return $q;
    }
    public function hasRelation($name){
        return method_exists($this, $name) && $this->$name instanceof Collection;
    }
    public function learnMethodType($classname,$method){
        $model = App::make($classname);
        $oReflectionClass = new \ReflectionClass($classname);
        $method = $oReflectionClass->getMethod($method);
        $type = get_class($method->invoke($model));
        return $type;
    }
    public function relationships() {

        $model = new static;

        $relationships = [];

        foreach((new \ReflectionClass($model))->getMethods(\ReflectionMethod::IS_PUBLIC) as $method)
        {
            if ($method->class != get_class($model) ||
                !empty($method->getParameters()) ||
                $method->getName() == __FUNCTION__) {
                continue;
            }

            try {
                $return = $method->invoke($model);

                if ($return instanceof Relation) {
                    $relationships[$method->getName()] = [
                        'type' => (new \ReflectionClass($return))->getShortName(),
                        'model' => (new \ReflectionClass($return->getRelated()))->getName()
                    ];
                }
            } catch(\ErrorException $e) {}
        }

        return $relationships;
    }
}