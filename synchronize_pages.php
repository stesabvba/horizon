<?php

include_once("database.php");
include_once("functions.php");
include_once("classes.php");

set_time_limit(0);
use Illuminate\Database\Capsule\Manager as DB;

echo("Page synchronizer V1.0\n");
echo("===============================\n");


$page_found = 0;
$development_page_id = 0;

$page = null;

while($page_found==0)
{
	
	$answer = readline("Please insert a page reference: ");

	$reference = $answer;

	$page = Page::where('reference',$reference)->first();

	$development_page = DB::connection("development")->select("SELECT * FROM page WHERE reference=:reference",["reference" => $reference]);
	if(count($development_page)>0)
	{
		$development_page_id = $development_page[0]->id;

	}

	if($page!=null)
	{
		var_dump($page);

		$page_found=1;
	}else{

		
		$answer = readline("Do you want to create a new page with reference: $reference Y/N: ");
		
		while(!in_array($answer,array('Y','N')))
		{
			$answer = readline("Do you want to create a new page with reference: $reference Y/N: ");
		}

		if($answer=="Y")
		{


			if(count($development_page)>0)
			{
				$page = new Page();
				$page->reference = $development_page[0]->reference;
				$page->parent_id = $development_page[0]->parent_id;
				$page->theme_id = $development_page[0]->theme_id;
				$page->active = $development_page[0]->active;
				$page->show_in_menu = $development_page[0]->show_in_menu;
				$page->login_required = $development_page[0]->login_required;
				$page->presentation_order = $development_page[0]->presentation_order;

				$page->save();

				echo("Created a new page online with reference: $reference\n");
				$page_found=1;


			}

		}else{
			exit(0);
		}
	}


}

if($page!=null){

	$development_page_metas = DB::connection("development")->select("SELECT * FROM page_meta WHERE page_id=:page_id",["page_id" => $development_page_id]);

	foreach($development_page_metas as $development_page_meta)
	{

		$page_meta = PageMeta::where('page_id',$page->id)->where('language_id',$development_page_meta->language_id)->first();

		if($page_meta!=null)
		{

			


			$page_meta->name = $development_page_meta->name;
			$page_meta->title = $development_page_meta->title;		
			$page_meta->description = $development_page_meta->description;
			$page_meta->keywords = $development_page_meta->keywords;
			$page_meta->save();

			echo("Existing pagemeta overwritten\n");

		}else{

			$page_meta = new PageMeta();
			$page_meta->page_id = $page->id;
			$page_meta->name = $development_page_meta->name;
			$page_meta->language_id = $development_page_meta->language_id;
			$page_meta->title = $development_page_meta->title;
			$page_meta->description = $development_page_meta->description;
			$page_meta->keywords = $development_page_meta->keywords;

			$page_meta->save();
		}



		//sync routes


		$development_routes = DB::connection("development")->select("SELECT * FROM route WHERE page_meta_id=:page_meta_id",["page_meta_id" => $development_page_meta->id]);

		$active_routes = Route::where('page_meta_id',$page_meta->id)->get()->keyBy('id');



		foreach($development_routes as $development_route)
		{

			$route = Route::where('page_meta_id',$page_meta->id)->where('uri',$development_route->uri)->where('method',$development_route->method)->where('controller_function',$development_route->controller_function)->first();

			if($route!=null)
			{
				echo("Identical route does already exist\n");

				unset($active_routes[$route->id]);

			}else{
				$route = new Route();
				$route->page_meta_id=$page_meta->id;
				$route->uri=$development_route->uri;
				$route->method = $development_route->method;
				$route->controller_function = $development_route->controller_function;
				$route->load_default_view = $development_route->load_default_view;
				$route->save();

				echo("New route created\n");
			}
		}


		if(count($active_routes)>0){

			foreach($active_routes as $route)
			{
				$route->delete();
			}

		}

	}

}


		




?>