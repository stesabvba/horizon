<?php
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Database\Capsule\Manager as Capsule;  
	
	class CreateReportMigration {
		public function up(){
			if(!Capsule::schema()->hasTable('report')){
				Capsule::schema()->create('report', function (Blueprint $table) {
					$table->increments('id');
					$table->string('name',50);
					$table->string('orientation',50)->nullable();;
					$table->string('module',50)->nullable();
					$table->string('filename',200)->nullable();
					$table->timestamps();
					
				});
			}

			if(!Capsule::schema()->hasTable('report_exclusion')){
				Capsule::schema()->create('report_exclusion', function (Blueprint $table) {
					$table->increments('id');
					$table->integer('report_id')->unsigned();
					$table->integer('product_id');
					$table->integer('exclusion_type');
					$table->integer('exclusion_id');
					$table->timestamps();

					$table->foreign('product_id')->references('id')->on('product')->onDelete('cascade');
					$table->foreign('report_id')->references('id')->on('report')->onDelete('cascade');
					
				});
			}


			if(!Capsule::schema()->hasTable('report_profile')){
			Capsule::schema()->create('report_profile', function (Blueprint $table) {
				$table->increments('id');
				$table->integer('profile_id')->unsigned();
				$table->integer('report_id')->unsigned();
				$table->unique(['profile_id', 'report_id']);
				
				$table->foreign('profile_id')->references('id')->on('profile')->onDelete('cascade');
				$table->foreign('report_id')->references('id')->on('report')->onDelete('cascade');
				
			});
			}



			
					
		}
		
		public function down(){
			if(Capsule::schema()->hasTable('report_profile')){
				Capsule::schema()->drop('report_profile');
			}

			if(Capsule::schema()->hasTable('report_exclusion')){
				Capsule::schema()->drop('report_exclusion');
			}

			if(Capsule::schema()->hasTable('report')){
				Capsule::schema()->drop('report');
			}
		}
	}
?>