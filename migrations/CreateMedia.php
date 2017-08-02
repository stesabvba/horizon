<?php
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Capsule\Manager as Capsule;  
	
	class CreateMediaMigration {
		public function up(){
			if(!Capsule::schema()->hasTable('media')){
				Capsule::schema()->create('media', function (Blueprint $table) {
					$table->increments('id')->unsigned();
					$table->string('name',100);
					$table->string('media_type',100);
					$table->text('filename');
					$table->timestamps();
				});
			}
			
			if(!Capsule::schema()->hasTable('media_meta')){
				Capsule::schema()->create('media_meta', function (Blueprint $table) {
					$table->increments('id')->unsigned();
					$table->integer('media_id')->unsigned();
					$table->integer('language_id')->unsigned()->nullable();
					$table->string('meta_name',100);
					$table->text('meta_value');
					
					$table->timestamps();
					$table->foreign('media_id')->references('id')->on('media')->onDelete('cascade');
					$table->foreign('language_id')->references('id')->on('language')->onDelete('set null');
				});
			}

			if(!Capsule::schema()->hasTable('media_tag')){
				Capsule::schema()->create('media_tag', function (Blueprint $table) {
					$table->increments('id')->unsigned();
					$table->integer('media_id')->unsigned();
					$table->integer('tag_id')->unsigned();
					
					$table->timestamps();
					$table->foreign('media_id')->references('id')->on('media')->onDelete('cascade');
					$table->foreign('tag_id')->references('id')->on('tag')->onDelete('cascade');
				});
			}

			if(!Capsule::schema()->hasTable('media_version')){
				Capsule::schema()->create('media_version', function (Blueprint $table) {
					$table->increments('id')->unsigned();
					$table->integer('media_id')->unsigned();
					$table->integer('old_media_id')->unsigned();
					
					$table->timestamps();
					$table->foreign('media_id')->references('id')->on('media')->onDelete('cascade');
					$table->foreign('old_media_id')->references('id')->on('media')->onDelete('cascade');
					
				});
			}
		}
		
		public function down(){

			if(Capsule::schema()->hasTable('media_version')){
				Capsule::schema()->drop('media_version');
			}

			if(Capsule::schema()->hasTable('media_tag')){
				Capsule::schema()->drop('media_tag');
			}
			
			if(Capsule::schema()->hasTable('media_meta')){
				Capsule::schema()->drop('media_meta');
			}
			
			if(Capsule::schema()->hasTable('media')){
				Capsule::schema()->drop('media');
			}
		}
	}
?>