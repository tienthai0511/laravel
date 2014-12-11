<?php

class DemoController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function index()

	{
		$title =  "xin chào laravel";
		#selecy by query
		/*$results = DB::select('select * from post ');
		echo "<pre>";
		print_r($results);
		foreach ($results as $key => $value) {
			echo ($value->id);
		}
		echo "<pre>";
		*/
		#using query buider
		//get all colum 
		$post = DB::table('post')->get();
		// condition
		$post = DB::table('post')->where('id','>','1')->first();// get firts row
		$colum = DB::table('post')->where('id','>','1')->pluck('title');// get firts row
		print_r($post);
		print_r( 'colum : ' .$colum);
		foreach ($post as $post)
		{
			//var_dump($post->id);
		}
		
		return View::make('demo.index')->with("title", $title);
		
	}
	public function del($id){
		$b= 2;
		echo 1;
		return  View::make("demo.del");
	}
	public function getContent($dasda){
		return View::make('demo.index');
	}
	public function getAction($dasda,$n){
		return View::make('demo.action');
	}
	
}
