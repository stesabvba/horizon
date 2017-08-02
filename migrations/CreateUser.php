<?php

	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Capsule\Manager as Capsule;  
	
	
	class CreateUserMigration{
		
		public function up(){
			if(!Capsule::schema()->hasTable('user')){
				Capsule::schema()->create('user', function (Blueprint $table) {
					$table->increments('id');
					$table->string('firstname',50);
					$table->string('lastname',50);
					$table->string('email',50)->unique();
					$table->string('company', 100);
					$table->string('phone', 100)->nullable();
					$table->string('username',50);
					$table->string('password',50);
					$table->string('password_resetkey', 32)->nullable();
					$table->integer('profile_id')->unsigned()->nullable();
					$table->integer('communication_language_id')->unsigned()->nullable();
					$table->tinyInteger('active')->default(1);
					$table->timestamp('lastloggedin_at');
					$table->timestamps();
					
					$table->foreign('profile_id')->references('id')->on('profile')->onDelete('set null');
					$table->foreign('communication_language_id')->references('id')->on('language')->onDelete('set null');
				});
			}
	
			if(!Capsule::schema()->hasTable('userright')){
				Capsule::schema()->create('userright', function (Blueprint $table) {
					$table->increments('id');
					$table->string('name',50);
					$table->integer('parent_id');
					$table->integer('page_id')->unsigned()->nullable();
					$table->timestamps();
					
					$table->foreign('page_id')->references('id')->on('page')->onDelete('cascade');
				});
			}
		}
		
		public function down(){
			if(Capsule::schema()->hasTable('userright')){
				Capsule::schema()->drop('userright');
			}
			
			if(Capsule::schema()->hasTable('user')){
				Capsule::schema()->drop('user');
			}
		}
	}
	
	
	
	
	

?>