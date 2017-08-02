<?php
include_once("database.php");
include_once("functions.php");
include_once("classes.php");
include_once("site.php");
session_start();
include_once("page.php");
include_once('htmlhelper.php');
require_once('message.class.php');
require_once('validate.class.php');


$html_helper = new htmlhelper();
$msg_helper = new MsgHelper();

$output = "";
$script="";
$content = "";
$context = "";
$customjs = "";
$meta_tags = "";

if($active_route->controller_function!=null){
	
	$parts = explode("@",$active_route->controller_function);
	
	$class = $parts[0];
	$function = $parts[1];
	
	require_once("controllers/$class.php");
	$obj = new $class;
	if($active_route->method=='POST'){
		$output = $obj->{$function}($_POST);
	}else{
		$output = $obj->{$function}($_GET);
	}
}

if($active_route->load_default_view==1){
	LoadView();
}else{
	echo($output);
}

$msg_helper->delete('messages', -1);
?>