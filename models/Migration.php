<?php


	class Migration extends Illuminate\Database\Eloquent\Model {
		protected $table='migration';
		
		public function execute()
		{
			include_once("modules/config/database/migrations/".$this->location);
		}
		
	}
	
	
	//First time execute
	/*
	$file_list = scandir("modules/config/database/migrations/");

	foreach($file_list as $file){
		$split_file = explode(".",$file);
		if($split_file[1] == "php"){
		//Migration!
			$migration = new Migration;
			$migration->location = $file;
			$migration->save();
		}
	}
	*/
?>