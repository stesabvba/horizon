<?php

	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Capsule\Manager as Capsule;  
	
	class CreateMenuMigration{
		
		public function up(){
			if(!Capsule::schema()->hasTable('menu')){
				Capsule::schema()->create('menu', function (Blueprint $table) {
					$table->increments('id');
					$table->string('name',50);
				
					$table->timestamps();
				});
			}
			
			if(!Capsule::schema()->hasTable('menu_item')){
				Capsule::schema()->create('menu_item', function (Blueprint $table) {
					$table->increments('id');
					$table->integer('menu_id')->unsigned()->nullable();
					$table->integer('language_id')->unsigned()->nullable();
					$table->integer('page_meta_id')->unsigned()->nullable();
					$table->integer('media_id')->unsigned()->nullable();
					$table->string('menu_text',100);
					$table->text('alternate_uri');
					$table->integer('parent_id')->unsigned();
					$table->integer('presentation_order');
					
					$table->timestamps();
					
					$table->foreign('menu_id')->references('id')->on('menu')->onDelete('cascade');
					$table->foreign('language_id')->references('id')->on('language')->onDelete('cascade');
					$table->foreign('page_meta_id')->references('id')->on('page_meta')->onDelete('cascade');
					$table->foreign('media_id')->references('id')->on('media')->onDelete('set null');
					
				});
			}
		}
		
		
		public function down(){
			
			if(Capsule::schema()->hasTable('menu_item')){
				Capsule::schema()->drop('menu_item');
			}
			
			if(Capsule::schema()->hasTable('menu')){
				Capsule::schema()->drop('menu');
			}
		}
	}

	
	
?>