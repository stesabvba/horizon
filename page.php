<?php

$uri = rtrim( dirname($_SERVER["SCRIPT_NAME"]), '/' );
//echo 'uri='.$uri . "<br/>";
$uri = '/' . trim( str_replace( $uri, '', $_SERVER['REQUEST_URI'] ), '/' );
//echo 'uri='.$uri  . "<br/>";
//$uri = substr($_SERVER['REQUEST_URI'], 8); // /horizon wegdoen
$uri = urldecode( substr($uri,1) );
//echo 'uri='.$uri . "<br/>";
//die('hier');

/// FIND Page
$globals = [];
$active_pagemeta = null;
$active_page = null;
$active_route = null;
$parameters = array();
$language_id = 1;

if(!empty($_POST) || !empty($_FILES)){
	$routes = Route::where('method','POST')->orderBy('uri')->get();
}else{
	$routes = Route::where('method','GET')->orderBy('uri')->get();
}

foreach($routes as $route)
{
		
	$path = $route->uri;

	$params=extractOptionalParameters($path);
	
	//echo("PATH: $path <br/>");
	$regexp=preg_replace('/\/{\w+}/','(/[0-9a-zA-Z\-]+){0,1}',$path); //orig
	
	$regexp=preg_replace('/\//','\/',$regexp);
	$regexp="/^" . $regexp . "(\?.*){0,1}$/";
	preg_match($regexp, $uri, $matches);

	if(count($matches)>0){
		/*echo '<pre>';
		print_r($matches);
		echo '</pre>';*/

		$active_route = $route;
		$active_pagemeta = $route->pagemeta;
		$active_page = $active_pagemeta->page;
		$language_id = $active_pagemeta->language_id;
		//$globals['language'] = Language::find($language_id);
		$globals['site_config'] = $site_config;
		$globals['active_route'] = $route;
		$globals['current_url'] = $site_config['site_url']->value.$route->uri;
		$globals['active_pagemeta'] = $active_pagemeta;
		$globals['active_page'] = $active_page;
		$globals['language_id'] = $language_id;
		
		if(count($params)>0){
			
			for($i=1; $i<count($matches); $i++){
				array_push($parameters,str_replace('/','',$matches[$i]));
			}
		}
		
		break;
	}
	
}

$active_user = null;

$logged_in = 0;



if(isset($_SESSION['active_user'])){
	$active_user = $_SESSION['active_user'];
	$active_user = User::find($active_user->id);
	$logged_in = 1;
}else{
	$language = Language::find($language_id);
	$active_user = User::where('username','default_user_' . $language->shortname)->first();	
}

if($active_pagemeta == null){

	header("HTTP/1.0 404 Not Found");

	
	$language = Language::where('shortname',substr($uri,0,strpos($uri,'/')))->first();
	if($language!=null)
	{
		$language_id = $language->id;	
	}else{
		$language_id = 1;
		$language = Language::find($language_id);
	}	
	
	
	$active_page = Page::where('reference','page_not_found')->first();
	$active_pagemeta = $active_page->pagemetas()->where('language_id',$language_id)->first();
	$active_route = $active_pagemeta->defaultroute();	
}

if(!$active_user->can('view_' . $active_page->reference . "_page")){

	if($active_user->profile_id == 2) //visitor
	{
		header("Location:" . pagelink('login',$language_id));
	}else{
		header("HTTP/1.0 403 Not Found");
		
		
		$active_page = Page::where('reference','user_not_authorized')->first();
		$active_pagemeta = $active_page->pagemetas()->where('language_id',$language_id)->first();
		$active_route = $active_pagemeta->defaultroute();
	}
	
	
}

$globals['language'] = Language::find($language_id);

$user_message = "";






?>
