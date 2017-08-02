<?php

	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Capsule\Manager as Capsule;  
	
	class CreateProfileMigration{
		
		public function up(){
			if(!Capsule::schema()->hasTable('profile')){
			Capsule::schema()->create('profile', function (Blueprint $table) {
				$table->increments('id');
				$table->string('name',30);
				$table->tinyInteger('enduser');
				$table->tinyInteger('active');
				$table->timestamps();
			});
			}
			
			if(!Capsule::schema()->hasTable('profile_userright')){
			Capsule::schema()->create('profile_userright', function (Blueprint $table) {
				$table->increments('id');
				$table->integer('profile_id');
				$table->integer('userright_id');
				$table->unique(['profile_id', 'userright_id']);
				
				$table->foreign('profile_id')->references('id')->on('profile')->onDelete('cascade');
				$table->foreign('userright_id')->references('id')->on('userright')->onDelete('cascade');
			});
			}
		}
		
		public function down(){
			if(Capsule::schema()->hasTable('profile_userright')){
				Capsule::schema()->drop('profile_userright');
			}
			if(Capsule::schema()->hasTable('profile')){
				Capsule::schema()->drop('profile');
			}
		}
	}
	

?>