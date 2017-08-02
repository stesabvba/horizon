<?php

	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Capsule\Manager as Capsule;  
	
	class CreateMailMigration{
		
		public function up(){
			if(!Capsule::schema()->hasTable('mail')){
			Capsule::schema()->create('mail', function (Blueprint $table) {
				$table->increments('id');
				$table->text('subject')->nullable();
				$table->text('from');
				$table->text('to');
				$table->text('cc')->nullable();
				$table->text('bcc')->nullable();
				$table->text('reply_to')->nullable();
				$table->text('content')->nullable();
				$table->text('attachments')->nullable();
				$table->integer('user_id')->unsigned()->nullable();
				$table->integer('language_id')->unsigned()->nullable();
				$table->timestamp('sent_at');
				$table->timestamps();
				
				$table->foreign('user_id')->references('id')->on('user')->onDelete('set null');
				$table->foreign('language_id')->references('id')->on('language')->onDelete('set null');
			});
			}
		}
		
		public function down(){
			if(Capsule::schema()->hasTable('mail')){
				Capsule::schema()->drop('mail');
			}
		}
	}
	


?>