<?php
include_once("database.php");
include_once("functions.php");
include_once("classes.php");


	$parts = explode("@",$argv[1]);
	
	$class = $parts[0];
	$function = $parts[1];
	
	if(isset($argv[2])){
		$arguments = explode('-',$argv[2]);
	}
	
	
	require_once("controllers/$class.php");
	$obj = new $class;

	if(!empty($arguments))
	{	
		
		$obj->{$function}($arguments[0],$arguments[1]);
	}else{
		$obj->{$function}();
	}




?>