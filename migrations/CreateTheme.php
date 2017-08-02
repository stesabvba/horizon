<?php

	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Capsule\Manager as Capsule;  
	
	
	class CreateThemeMigration{
		
		public function up(){
			if(!Capsule::schema()->hasTable('theme')){
				Capsule::schema()->create('theme', function (Blueprint $table) {
					$table->increments('id');
					$table->string('name',50);
					$table->string('location',200);
					$table->tinyInteger('active');
					$table->timestamps();
				});
			}
		}
		
		public function down(){
			if(Capsule::schema()->hasTable('theme')){
				Capsule::schema()->drop('theme');
			
			}
		}
	}
	
	
	
	
?>