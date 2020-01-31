<?php

namespace App\Http\Controllers;

use App\Services\Help;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\UnauthorizedException;

class BreadController extends Controller
{
    public function index(Request $request, $model){
        $model_name = Help::getClassName($model);
        $model = App::make($model_name);
        $data = $model_name::owner()->filter()->paginate(($request->per_page)? $request->per_page : 25);

        return response()->json($data);
    }
    public function store(Request $request, $model){
        $request->request->set('user_id', $request->user('api')->id);
        $model_name = Help::getClassName($model);
        $model = App::make($model_name);
        $validation = $model->storeValidation();
        if(method_exists($model, 'modifyStoreRequest')){
            $request = $model->modifyStoreRequest($request);
        }
        $request->validate($validation);
        $model = $model_name::create($request->all());
        $this->resolveRelations($request, $model, $model_name);
        return response()->json(true);
    }
    public function show(Request $request, $model, $id){
        $model_name = Help::getClassName($model);
        $example_model = App::make($model_name);
        $model = $model_name::where('id', $id)->first();
        if(!$model) throw new \Exception('Brak modelu');
        $relations = collect();
        foreach ($example_model->relationships() as $relation => $data){
            $r = $model->$relation;
            if($r instanceof Collection){
                $r = $r->map(function ($item){
                    return $item->id;
                })->toArray();
            }

            $relations->push((object) ['name' => $relation, 'data' => $r]);
        }
        $this->checkPermission($model);
        $model = $model->toArray();
        foreach ($relations as $data){
            $model[$data->name] = $data->data;
        }
        return response()->json($model);
    }
    public function checkPermission($model){
        if(array_search('user_id', $model->getFillable())){
            if($model->user_id != \request()->user('api')->id) throw new UnauthorizedException();
        }
    }
    public function update(Request $request, $model, $id){
        $model_name = Help::getClassName($model);
        $model = $model_name::where('id', $id)->first();
        if(!$model) throw new \Exception('Brak modelu');
        $this->checkPermission($model);
        $validation = $model->updateValidation();
        $request->validate($validation);
        $model->update($request->all());
        $this->resolveRelations($request, $model, $model_name);
        return response()->json($model);
    }
    public function resolveRelations($request, $model, $model_name){
        foreach ($request->all() as $key => $field){
            if(is_array($field) && $model->hasRelation($key)){
                $type = $model->learnMethodType($model_name, $key);
                if($type == 'Illuminate\Database\Eloquent\Relations\BelongsToMany'){
                    $model->$key()->detach();
                    foreach ($field as $id){
                        $model->$key()->attach($id);
                    }
                }
            }
        }
    }
}
