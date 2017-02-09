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

Route::group(["middleware" => "api"], function(){
    Route::get('task', function() {
        return App\Task::latest()->orderBy('created_at', 'desc')->get();
    });

    Route::get('task/{id}', function($id) {
        return App\Task::findOrFail($id);
    });

    Route::post('task/store', function(Request $request) {
        return App\Task::create(['content' => $request->input(['content'])]);
    });

    Route::patch('task/{id}', function(Request $request, $id) {
        App\Task::findOrFail($id)->update(['content' => $request->input(['content'])]);
    });

    Route::delete('task/{id}', function($id) {
        return App\Task::destroy($id);
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
