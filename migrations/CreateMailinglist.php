<?php

	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Capsule\Manager as Capsule;  
	
	class CreateMailinglistMigration{
		
		public function up(){
			if(!Capsule::schema()->hasTable('mailinglist')){
			Capsule::schema()->create('mailinglist', function (Blueprint $table) {
				$table->increments('id');
				$table->text('name');
				$table->string('mailchimp_id',50);
				$table->timestamps();
				

			});
			}
			
			if(!Capsule::schema()->hasTable('user_mailinglist')){
			Capsule::schema()->create('user_mailinglist', function (Blueprint $table) {
				$table->increments('id');
				$table->integer('mailinglist_id')->unsigned()->nullable();
				$table->integer('user_id')->unsigned()->nullable();
				
				$table->timestamps();
				
				$table->foreign('mailinglist_id')->references('id')->on('mailinglist')->onDelete('cascade');
				$table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');

			});
			}
			
		
		}
		
		public function down(){
			if(Capsule::schema()->hasTable('user_mailinglist')){
				Capsule::schema()->drop('user_mailinglist');
			}

			if(Capsule::schema()->hasTable('mailinglist')){
				Capsule::schema()->drop('mailinglist');
			}
			
		}
	}
	
	

?>