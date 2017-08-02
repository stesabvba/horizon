<?php
	//Created by Steven

	require_once(__DIR__ . '/controllers/BaseController.php');

	$files = glob(__DIR__ . '/models/*.php');

	foreach($files as $file) {
		require_once($file);
		
	}
	
	


?>