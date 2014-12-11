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
	/*	$title =  "xin chào laravel";
		#selecy by query
		$results = DB::select('select * from post where id = ?', array(1));
		#using query buider
		//get all colum 
		$post = DB::table('post')->get();
		//condition with id > 1
		$post = DB::table('post')->where('id','>','1')->first();// get firts row
		$colum = DB::table('post')->where('id','>','1')->pluck('title');// get firts row colum `title`
		# sepecial select 
		$post1 = DB::table('post')->select('title', 'id')->get();
		$post2 = DB::table('post')->distinct()->get();
		$post3 = DB::table('post')->select('title as title_name')->get();
		//Adding A Select Clause To An Existing Query
		$query = DB::table('post')->select('title');
		$post3 = $query->addSelect('content')->get();
		//Using Where Operators
		$post4 = DB::table('post')->where('id', '>', 10)->get();
		// OrderStatements 
		$post4  = DB::table('post')->where('id' ,'>', 1)->orWhere('id','<',10)->get();
		//Using Where Between (1,10)
		$post4  = DB::table('post')->whereBetween('id' , array(1,8))->get();
		$post4 = DB::table('post')->whereNotBetween('id', array(1, 100))->get();
		//Using Where In With An Array
		$post4 = DB::table('post')
					->whereIn('id', array(1, 2, 3))->get();
		$post4 = DB::table('post')
					->whereNotIn('id', array(1, 2, 3))->get();
		//Using Where Null To Find Records With Unset Values
		$post4 = DB::table('post')
					->whereNull('created')->get();
		//Order By, Group By, And Having
		$post4 = DB::table('post')
					->orderBy('id', 'asc') //orderBy('id') deffual ASC
					->orderBy('title', 'desc')
					->groupBy('id')
					->having('id', '>', 3)
					->get();
		//offset & Limit
		$post4 = DB::table('post')->skip(10)->take(5)->get(); // get id > 10 limit 5 records

		####################################################################
		# JOIN 
		####################################################################

		//Basic Join Statement
		$post4 = DB::table('post')
				->join('post_re', 'post.id', '=', 'post_re.idpost')
				//->join('orders', 'users.id', '=', 'orders.user_id')
				->select('post.id', 'post_re.title', 'post.title')
				->get();
		// left join 
		$post4 = DB::table('post')
				->leftJoin('post_re', 'post.id', '=', 'post_re.idpost')
				->get();
		//left join have condition
		$post4 = DB::table('post')
				->leftjoin('post_re', function($join)
				{
					$join->on('post.id', '=', 'post_re.idpost')
						 ->where('post_re.id', '>', 1);
				})
				->get();
		#####################################################################
		#Advanced Wheres
		#####################################################################

		$post4 = DB::table('post')
					//->where('id','<', 100)
					->where(function($query)
					{
						$query->where('id','>',3);
						//->whereNotNull('created');
						//->where
					})
					->get();
		// update query
		$post4 = DB::table('post')->where('id',1)->update(array('title' => 'test update1'));
		
		#Using A Raw Expression
		$post4 = DB::table('post')
					->select(DB::raw('count(*) as user_count,id, title'))
					->where('id', '<>', 4)
					->groupBy('id')
					->get(); 
		#insert records tinto table 
		/*$post4 = DB::table('post')->insertGetId(
			array('title' => 'john@example.com', 'content' => 'content','created'=> date('Y-m-d H:i:s'))
		);*/

		#####################################################################
		#Eloquent ORM
		#####################################################################

	/*	$posts_model = Post::all();
		foreach($posts_model as $key => $value) {
			//echo $value->title;
		}
		// throw an exception
		$posts_model = Post::findOrFail(1);

		$posts_model = Post::where('id', '>', 1)->firstOrFail();
		// count 
		$posts_model = Post::where('id', '<', 10)->count();
		//$posts_model = Post::whereRaw('id < ? and content IS NOT NULL', array(3))->get();
*/
		$posts_model = Post::where('id', '<', 10)->get();
print_r($posts_model);
		
/*DB::table('post')->insert(
    array('title' => 'jdoe',
          'content' => 'john',
          'created' => 'NOW()')
);*/
$logFile = 'laravel.log';
$post = new Post;
$post->id = null;
$post->title = "taa";
$post->content = "taa";
$post->created = 'NOW()';
$post->save();

Log::useDailyFiles(storage_path().'/logs/'.$logFile);
		// update 
		$title = "sss";
			
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
