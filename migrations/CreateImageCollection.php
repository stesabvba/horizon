<?php
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Capsule\Manager as Capsule;  
	
	class CreateImageCollectionMigration {
		public function up(){
			if(!Capsule::schema()->hasTable('image_collection')){
				Capsule::schema()->create('image_collection', function (Blueprint $table) {
					$table->increments('id');
					$table->string('name',200);
					$table->timestamps();
					
				});
			}
			
			if(!Capsule::schema()->hasTable('image_collection_content')){
				Capsule::schema()->create('image_collection_content', function (Blueprint $table) {
					$table->increments('id');
					$table->integer('slider_id')->unsigned()->nullable();
					$table->integer('media_id')->unsigned()->nullable();
					$table->string('format',50);
					$table->integer('presentation_order',11)->default(0);
					$table->timestamps();
					
					$table->foreign('slider_id')->references('id')->on('slider')->onDelete('cascade');
					$table->foreign('media_id')->references('id')->on('media')->onDelete('cascade');
					
				});
			}
		}
		
		public function down(){
			
			if(Capsule::schema()->hasTable('image_collection_content')){
				Capsule::schema()->drop('image_collection_content');
			}
			
			if(Capsule::schema()->hasTable('image_collection')){
				Capsule::schema()->drop('image_collection');
			}
		}
	}
?>