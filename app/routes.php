<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});
Route::get("demo/del/{id?}",function($id=null){
	$data['id'] = 9999;
    if($id!=null){
		
    }else{
         return "Hello thaivt - With Laravel Tutorial";
    }
	return  View::make("demo.del",$data);
})->where(array("id"=>"[0-9]+"),"DemoController@del");// tham soos phair laf số
Route::get("demo","DemoController@index"); 
Route::get("demo/content/{id}",array("as"=>"list","uses" => "DemoController@getContent")); 
Route::get("demo/content/{id}-action-{action}",array("as"=>"action","uses" => "DemoController@getAction")); 

