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

Route::prefix('admin')->group(function (){
	Route::middleware(['permission:create_user'])->group(function (){
		Route::resource('users','UserController');
		Route::resource('groups','GroupController');
		Route::get('download',function (){
			$file = storage_path()."/app/default.xls";
			return response()->download($file);
		})->name('download');
		Route::get('delete/',function(\Illuminate\Http\Request $request){
			$user = \App\User::findOrFail($request->id);
			$user->removeRole($request->name);
			return response("ok",200);
		})->name('deleteUserFromGroup');
		Route::get('search_user',function(\Illuminate\Http\Request $request){
			$data = $request->data;
			$users = \App\User::where('stuId','like',"%{$data}%")->orWhere('name','like',"%{$data}%")->get()->toArray();
			return response($users,200);
		})->name('search_user');
	});
	Route::middleware('permission:create_act')->group(function (){
		Route::resource('act','ActController');
		Route::resource('work','WorkController');
		Route::post('sign','ActController@sign')->name('sign');
		Route::get('pdf/{id}','ActController@pdf')->name('pdf');
	});
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('test','ActController@pdf');
