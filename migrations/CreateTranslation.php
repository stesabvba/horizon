<?php

	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Capsule\Manager as Capsule;  
	
	
	class CreateTranslationMigration{
		
		public function up(){
			if(!Capsule::schema()->hasTable('translation')){
			Capsule::schema()->create('translation', function (Blueprint $table) {
				$table->increments('id');
				$table->string('reference',50);
				$table->integer('language_id')->unsigned()->nullable();
				$table->text('translation');
				$table->tinyInteger('unstable');
				$table->tinyInteger('type');
				$table->timestamps();
				
				$table->index('reference');

				$table->unique(['reference', 'language_id']);
				
				$table->foreign('language_id')->references('id')->on('language')->onDelete('cascade');
			});
			}
		}
		
		public function down(){
			if(Capsule::schema()->hasTable('translation')){
				Capsule::schema()->drop('translation');
			}
		}
	}
	
	

?>