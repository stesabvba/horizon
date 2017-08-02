<?php
	class ProfileController extends BaseController {
		
		public function profiles(){			
			global $language_id;

			$profiles = Profile::all();

			$pagelink_edit = pagelink('profile_edit',$language_id);
			$pagelink_delete = pagelink('profile_delete',$language_id);
			$pagelink_copy = pagelink('profile_copy',$language_id);

			$template_vars = [
				'profiles' => $profiles,
				'pagelink_edit' => $pagelink_edit,
				'pagelink_delete' => $pagelink_delete,
				'pagelink_copy' => $pagelink_copy,
			];
			LoadView('admin/profiles/profiles.php', $template_vars);
		}
		
		public function profile_add_page(){			
			LoadView('admin/profiles/profile_add.php');
		}
		
		public function profile_add($request){
			global $language_id;
		
			$name = $request["name"];
			$enduser=0;
			$active=0;
			
			if(isset($request['enduser'])){
				$enduser=1;
			}
			if(isset($request['active'])){
				$active=1;
			}
			
			if(isset($request['userrights'])){
				$userrights=$request['userrights'];
			}else{
				$userrights=array();
			}
			
			$profile = new Profile();
			$profile->name=$name;
			$profile->enduser=$enduser;
			$profile->active=$active;
			$profile->save();
			
			while(list($key,$value)=each($userrights)){
				$profile->userrights()->attach($key);
			}
			
			header("Location: " . pagelink('profiles',$language_id));
			

		}
		
		public function profile_edit_page(){
			
			LoadView('admin/profiles/profile_edit.php');
		}
		
		public function profile_edit($request){			
			global $language_id,$active_user;
		
			$profile_id=$request["profile_id"];
			
			$name = $request["name"];
			$enduser=0;
			$active=0;
			
			if(isset($request['enduser'])){
				$enduser=1;
			}
			if(isset($request['active'])){
				$active=1;
			}
			
			
			$userrights=$request['userrights'];			
			
			$profile = Profile::find($profile_id);
			$profile->name=$name;
			$profile->enduser=$enduser;
			$profile->active=$active;
			
			$profile->userrights()->detach();
			
			$profile->save();
			
			while(list($key,$value)=each($userrights)){
				$profile->userrights()->attach($value);
			}
			
			
			$user_id = $active_user->id;
			$user = User::find($user_id);
			$_SESSION['active_user']=$user;
			
			header("Location: " . pagelink('profiles',$language_id));
			
		}
		
		public function profile_delete_page(){
			
			LoadView('admin/profiles/profile_delete.php');
		}
		
		public function profile_delete($request){
			global $language_id;
			
			$profile_id=$request["profile_id"];
			$profile = Profile::find($profile_id);
			$profile->delete();
			
			header("Location: " . pagelink('profiles',$language_id));
			
		}
		
		public function profile_copy($request){
			global $language_id;
			global $parameters;

			$profile_id = $parameters[0];

			$profile = Profile::find($profile_id);
			$new_profile = $profile->replicate();
			$new_profile->name.=' copy';
			$new_profile->save();

			foreach($profile->userrights as $userright)
			{
				$new_profile->userrights()->attach($userright->id);
			}

			header("Location: " . pagelink('profiles',$language_id));

		}
		public function userright_add_page(){
			
			LoadView('admin/profiles/userright_add.php');
		}
		
		public function userright_add($request){
			global $language_id;
			$name = $request["name"];
			
			$userright = new UserRight();
			$userright->name=$name;
			$userright->parent_id=0;
			$userright->save();
			
			header("Location: " . pagelink('profiles',$language_id));
		}
	}


?>