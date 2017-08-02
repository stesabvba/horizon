<?php

	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Capsule\Manager as Capsule;  
	
	
	class CreatePageMigration{
		
		public function up(){
			if(!Capsule::schema()->hasTable('page')){
				Capsule::schema()->create('page', function (Blueprint $table) {
					$table->increments('id');
					$table->string('reference',30);
					$table->integer('parent_id')->default(0);
					$table->integer('theme_id')->unsigned()->nullable();
					$table->text('custom_css');
					$table->text('custom_js');
					$table->tinyInteger('active');
					$table->tinyInteger('show_in_menu');
					$table->tinyInteger('login_required');
					$table->integer('presentation_order');
					$table->timestamps();
					
					$table->unique('reference');
					
					$table->foreign('theme_id')->references('id')->on('theme')->onDelete('set null');
					
				});
			
			}
			
			if(!Capsule::schema()->hasTable('page_meta')){
			
				Capsule::schema()->create('page_meta', function (Blueprint $table) {
					$table->increments('id');
					$table->integer('page_id')->unsigned()->nullable();
					$table->string('name',30);
				
					$table->integer('language_id')->unsigned()->nullable();
					$table->text('title');
					$table->text('description');
					$table->text('keywords');
					$table->string('controller_function',200)->nullable();
					$table->timestamps();
					
					$table->foreign('page_id')->references('id')->on('page')->onDelete('cascade');
					$table->foreign('language_id')->references('id')->on('language')->onDelete('cascade');
				});
			
			}
			
			if(!Capsule::schema()->hasTable('route')){
			
				Capsule::schema()->create('route', function (Blueprint $table) {
					$table->increments('id');
					$table->integer('page_meta_id')->unsigned()->nullable();
					$table->string('uri',400)->nullable();
					$table->string('method',10);
					$table->string('controller_function',200)->nullable();
					$table->tinyInteger('load_default_view');
					$table->timestamps();
					
					$table->foreign('page_meta_id')->references('id')->on('page_meta')->onDelete('cascade');

				});
			
			}
		}
		
		public function down(){
			if(Capsule::schema()->hasTable('route')){
				Capsule::schema()->drop('route');
			}
			if(Capsule::schema()->hasTable('page_meta')){
				Capsule::schema()->drop('page_meta');
			}
			
			if(Capsule::schema()->hasTable('page')){
				Capsule::schema()->drop('page');
			}
		}
	}
	
	
	
?>