<?php
	require('BaseController.php');

	class LanguageController extends \App\BaseController {
		
		public function languages(){
			global $language_id;

			$languages = Language::all();
			$pagelink_edit = pagelink('language_edit',$language_id);
			$pagelink_delete = pagelink('language_delete',$language_id);

			$template_vars = [
				'languages' => $languages,
				'pagelink_edit' => $pagelink_edit,
				'pagelink_delete' => $pagelink_delete,
			];
			LoadView('admin/languages/languages.php', $template_vars);
			
		}
		
		public function language_add_page(){
			
			LoadView('admin/languages/language_add.php');
			
		}
		
		public function language_add($request){
			
			global $language_id;
			
			$name = $request["name"];
			$shortname = $request["shortname"];
						
			$active=0;
			
			if(isset($request['active'])){
				$active=1;
			}
			
			$l = new Language();
			$l->name=$name;
			$l->shortname=$shortname;
			$l->active = $active;
			$l->save();
			
			
			header("Location: " . pagelink('languages',$language_id));
		}
		
		public function language_edit_page(){
			
			LoadView('admin/languages/language_edit.php');
		}
		
		public function language_edit($request){
			global $language_id;
			
			$l_id = $request["language_id"];
			$name = $request["name"];
			$shortname = $request["shortname"];
						
			$active=0;
			
			if(isset($request['active'])){
				$active=1;
			}
			
			$l = Language::find($l_id);
			$l->name=$name;
			$l->shortname=$shortname;
			$l->active = $active;
			$l->save();
			
			
			header("Location: " . pagelink('languages',$language_id));
		}
		
		public function language_delete_page(){
			
			LoadView('admin/languages/language_delete.php');
		}
		
		public function language_delete($request){
			global $language_id;
			
			$l_id = $request["language_id"];
		
			$l = Language::find($l_id);
			
			$l->delete();
			
			
			header("Location: " . pagelink('languages',$language_id));
		}
		
			
	}


?>