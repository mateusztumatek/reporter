<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Auth::routes(['verify' => true]);

Route::group(['middleware' => 'WebsiteUserMiddleware'], function (){
    Route::get('/website_user', 'WebsiteController@website_user');
    Route::post('/website_user', 'WebsiteController@updateUser');

    Route::get('/chat', 'ChatController@index');
/*    Route::post('/chat/markAsRead', 'ChatController@markAsRead');*/
    Route::get('/contacts', 'ContactController@index');

    Route::post('/chat_message', 'ChatController@message');
    Route::post('/reports', 'ReportController@store');
});
Route::get('/website', 'WebsiteController@show');
Route::group(['middleware' => 'auth:api'], function (){
   Route::resource('websites', 'WebsiteController');
   Route::get('/bread/{model}', 'BreadController@index');
    Route::get('/bread/{model}/{id}', 'BreadController@show');
    Route::put('/bread/{model}/{id}', 'BreadController@update');
    Route::post('/bread/{model}', 'BreadController@store');
    Route::get('/chats', 'ChatController@getChats');
    Route::get('/chats/{id}', 'ChatController@show');
    Route::post('/chats/message', 'ChatController@message');
    Route::post('/chats/markAsRead', 'ChatController@markAsRead');
    Route::post('/contacts', 'ContactController@save');


});
Route::resource('/users', 'UserController');
Route::post('/upload/update', 'UploadController@update');
Route::post('/upload/remove', 'UploadController@remove');
Route::post('/upload/{hash}', 'UploadController@upload');
Route::get('/upload/getuploads', 'UploadController@userUploads');
Route::get('user', function (Request $request){
    return response()->json($request->user('api'));
});