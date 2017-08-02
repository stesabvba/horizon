<?php

	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Capsule\Manager as Capsule;  
	
	class CreateLanguageMigration{
		
		public function up(){
			if(!Capsule::schema()->hasTable('language')){
				Capsule::schema()->create('language', function (Blueprint $table) {
					$table->increments('id');
					$table->string('name',30);
					$table->string('shortname',3);
					$table->tinyInteger('active');
					$table->timestamps();

				});
			}
		}
		
		public function down(){
			if(Capsule::schema()->hasTable('language')){
				Capsule::schema()->drop('language');
			}
		}
	}
	
	
?>