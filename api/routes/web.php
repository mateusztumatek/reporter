<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/source.js', function (){
    $js_content = \Illuminate\Support\Facades\View::make('js')->render();
    return Response::make($js_content, 200)->header('Content-Type', 'application/javascript');
});

Route::get('/stor/{filePath}', function (\Illuminate\Http\Request $request, $filepath){
    header("Access-Control-Allow-Origin: *");
    return response()->file(storage_path('/app/public/'.$filepath));
})->where(['filePath' => '.*']);

Route::get('/auth/{type}', 'Auth\LoginController@redirectExternal');
Route::get('/auth/{type}/callback', 'Auth\LoginController@externalCallback');
Route::get('/auth/callback_/{type}', 'Auth\LoginController@externalCallback');