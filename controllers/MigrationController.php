<?php
	require('BaseController.php');

	class MigrationController extends \App\BaseController {
		
		public function migrations()
		{
			
			LoadView('admin/migrations/migrations.php');
		}
		
		public function migration_execute()
		{
			global $parameters, $language_id;
			
			$migration = $parameters[0];
			
			ExecuteMigration($migration);
			
			header('Location: ' . pagelink('migrations',$language_id));
		}
		
		public function migration_rollback()
		{
			global $parameters, $language_id;
			
			$migration = $parameters[0];
			
			RollbackMigration($migration);
			
			header('Location: ' . pagelink('migrations',$language_id));
			
		}
		
		public function migration_add_page()
		{
			
			LoadView('admin/migrations/migration_add.php');
		}
		
		public function migration_add($request)
		{
			global $language_id;
			
			$migrationname = $request['name'];
			$migrationclass = $migrationname . "Migration";
			$content="<?php
			use Illuminate\Database\Schema\Blueprint;
			use Illuminate\Database\Capsule\Manager as Capsule;  
	
	class $migrationclass {
		public function up(){
			if(!Capsule::schema()->hasTable('')){
				Capsule::schema()->create('', function (Blueprint \$table) {
					\$table->increments('id');
					
					\$table->timestamps();
					\$table->foreign('')->references('')->on('')->onDelete('cascade');
					\$table->foreign('')->references('')->on('')->onDelete('set null');
				});
			}
		}
		
		public function down(){
			if(Capsule::schema()->hasTable('')){
				Capsule::schema()->drop('');
			}
		}
	}
?>";
			
			file_put_contents("migrations/$migrationname.php",$content);
			
			header('Location: ' . pagelink('migrations',$language_id));
		}
		
		
		public function migration_edit_page()
		{
			
			LoadView('admin/migrations/migration_edit.php');
		}
		
		public function migration_edit($request)
		{
			global $language_id;
			
			$migration = $request["migration"];
			$content = $request["content"];
			
			file_put_contents("migrations/$migration.php",$content);
			
			header('Location: ' . pagelink('migrations',$language_id));
			
		}
		
		public function migration_delete_page()
		{
			
			LoadView('admin/migrations/migration_delete.php');
		}
		
		public function migration_delete($request)
		{
			global $language_id;
			
			$migration = $request['migration'];
			
			unlink('migrations/' . $migration . '.php');
			
			header('Location: ' . pagelink('migrations',$language_id));
		}
	
	}


?>