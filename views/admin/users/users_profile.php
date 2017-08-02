<?php
	
	$user = User::find($active_user->id);
	
	if($user==null){
		header("Location: " . pagelink('users',$language_id));
	}
	
	
	$content.="<form id='order' class='form-horizontal' role='form' data-toggle='validator' method='POST'>";
	$content.="<div class='panel panel-default'>";
	$content.="<div class='panel-heading'>" . ucfirst(translate('user_edit')) . "</div>";
	$content.="<div class='panel-body'>";
	$content.="<input type='hidden' name='form_action' value='user_edit'/>";
	$content.="<input type='hidden' name='user_id' value='" . $user->id . "'/>";
	
	//firstname
	$content.="<div class='form-group'>";
	$content.="<label for='firstname' class='col-md-4 control-label'>" . ucfirst(translate('firstname')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<input name='firstname' id='firstname' type='text' class='form-control' value='" . $user->firstname . "' required/>";
	$content.="</div>";
	$content.="</div>";
	//end
	
	//lastname
	$content.="<div class='form-group'>";
	$content.="<label for='lastname' class='col-md-4 control-label'>" . ucfirst(translate('lastname')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<input name='lastname' id='lastname' type='text' class='form-control' value='" . $user->lastname . "' required/>";
	$content.="</div>";
	$content.="</div>";
	//end
	
	//email
	$content.="<div class='form-group'>";
	$content.="<label for='email' class='col-md-4 control-label'>" . ucfirst(translate('email')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<input name='email' id='email' type='text' class='form-control' value='" . $user->email . "' required/>";
	$content.="</div>";
	$content.="</div>";
	//end
	
	
	//username
	$content.="<div class='form-group'>";
	$content.="<label for='username' class='col-md-4 control-label'>" . ucfirst(translate('username')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<input name='username' id='username' type='text' class='form-control' value='" . $user->username . "' required/>";
	$content.="</div>";
	$content.="</div>";
	//end
	
	//password
	$content.="<div class='form-group'>";
	$content.="<label for='password' class='col-md-4 control-label'>" . ucfirst(translate('password')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<input name='password' id='password' type='password' class='form-control' value='" . $user->password . "' required/>";
	$content.="</div>";
	$content.="</div>";
	//end
	

	//profiles
	$content.="<div class='form-group'>";
	$content.="<label for='profile_id' class='col-md-4 control-label'>" . ucfirst(translate('user_usergroup')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<select name='profile_id' id='profile_id' class='form-control' required>";
	$content.="<option></option>";
	$usergroups = Usergroup::where('active',1)->get();
	foreach($usergroups as $usergroup){
		
		if($user->usergroup_id==$usergroup->id){
	
			$content.="<option value='" . $usergroup->id . "' selected>" . $usergroup->name . "</option>";
	
		}else{
			$content.="<option value='" . $usergroup->id . "'>" . $usergroup->name . "</option>";
		}
		
		
			
	}
	
	$content.="</select>";
	$content.="</div>";
	$content.="</div>";
	
	//end
	
	//ACTIVE
	
	$content.="<div class='form-group'>";
	$content.="<div class='col-md-6 col-md-offset-4'>";
    $content.="<div class='checkbox'>";
	if($user->active==1){
			$content.="<label><input type='checkbox' name='active' id='active' checked/>" . ucfirst(translate('user_active')) . "</label>";
	}else{
			$content.="<label><input type='checkbox' name='active' id='active' />" . ucfirst(translate('user_active')) . "</label>";
	}
	
	$content.="</div>";
   	$content.="</div>";
	$content.="</div>";
	//END 
	

	
	
	
	
	$content.="<div class='form-group'>";
	$content.="<div class='col-md-6 col-md-offset-4'>";
	$content.="<button type='submit' class='btn btn-primary'><i class='fa fa-btn fa-sign-in'></i> " . ucfirst(translate("update")) . "</button>";
	$content.="</div>";
	$content.="</div>";
	
	$content.=("</div>");
	$content.=("</div>");
	$content.=("</div>");
	$content.="</form>";
?>