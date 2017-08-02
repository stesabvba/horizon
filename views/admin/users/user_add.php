<?php

	$content.="<form id='order' class='form-horizontal' role='form' data-toggle='validator' method='POST'>";
	$content.="<div class='panel panel-default'>";
	$content.="<div class='panel-heading'>" . ucfirst(translate('user_add')) . "</div>";
	$content.="<div class='panel-body'>";
	$content.="<input type='hidden' name='form_action' value='user_add'/>";
	
	//firstname
	$content.="<div class='form-group'>";
	$content.="<label for='firstname' class='col-md-4 control-label'>" . ucfirst(translate('firstname')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<input name='firstname' id='firstname' type='text' class='form-control' />";
	$content.="</div>";
	$content.="</div>";
	//end
	
	//lastname
	$content.="<div class='form-group'>";
	$content.="<label for='lastname' class='col-md-4 control-label'>" . ucfirst(translate('lastname')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<input name='lastname' id='lastname' type='text' class='form-control' />";
	$content.="</div>";
	$content.="</div>";
	//end
	
	//email
	$content.="<div class='form-group'>";
	$content.="<label for='email' class='col-md-4 control-label'>" . ucfirst(translate('email')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<input name='email' id='email' type='text' class='form-control' required/>";
	$content.="</div>";
	$content.="</div>";
	//end
	
	
	//username
	$content.="<div class='form-group'>";
	$content.="<label for='username' class='col-md-4 control-label'>" . ucfirst(translate('username')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<input name='username' id='username' type='text' class='form-control' required/>";
	$content.="</div>";
	$content.="</div>";
	//end
	
	//password
	$content.="<div class='form-group'>";
	$content.="<label for='password' class='col-md-4 control-label'>" . ucfirst(translate('password')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<input name='password' id='password' type='password' class='form-control'/>";
	$content.="</div>";
	$content.="</div>";
	//end
	
	//
	$content.="<div class='form-group'>";
	$content.="<label for='communication_language_id' class='col-md-4 control-label'>" . ucfirst(translate('communication_language')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<select name='communication_language_id' id='communication_language_id' class='form-control' required>";
	$content.="<option></option>";
	$languages = Language::where('active',1)->get();
	foreach($languages as $language){

			$content.="<option value='" . $language->id . "'>" . $language->name . "</option>";
		
	}
	$content.="</select>";
	$content.="</div>";
	$content.="</div>";
	//profiles
	$content.="<div class='form-group'>";
	$content.="<label for='profile_id' class='col-md-4 control-label'>" . ucfirst(translate('user_profile')) . "</label>";
	$content.="<div class='col-md-6'>";
	
	if ($active_user->has_profile('admin')) {
		$str_disabled = '';
		$profile_id_selected = 0;
	} else {
		$str_disabled = ' disabled="disabled" ';
		$profile_id_selected = Profile::where('name', 'dealer')->first()->id;
	}
	

	$content.="<select name='profile_id' id='profile_id' class='form-control' ".$str_disabled." required>";
	$content.="<option></option>";
	$profiles = Profile::where('active',1)->get();
	foreach($profiles as $profile){
		if($profile->enduser==1){
			$lbl_option = $profile->name . " (enduser)";
		} else {
			$lbl_option = $profile->name;
		}

		$str_sel = ($profile_id_selected == $profile->id)?' selected="selected" ':'';

		$content.="<option value='" . $profile->id . "' ".$str_sel.">" .$lbl_option. "</option>";
	}
	
	$content.="</select>";
	$content.="</div>";
	$content.="</div>";
	
	//end
	
	//ACTIVE
	
	$content.="<div class='form-group'>";
	$content.="<div class='col-md-6 col-md-offset-4'>";
    $content.="<div class='checkbox'>";
	$content.="<label><input type='checkbox' name='active' id='active' checked/>" . ucfirst(translate('user_active')) . "</label>";
	$content.="</div>";
   	$content.="</div>";
	$content.="</div>";
	//END 
	

	
	
	
	
	$content.="<div class='form-group'>";
	$content.="<div class='col-md-6 col-md-offset-4'>";
	$content.="<button type='submit' class='btn btn-primary'><i class='fa fa-btn fa-sign-in'></i> " . ucfirst(translate("add")) . "</button>";
	$content.="</div>";
	$content.="</div>";
	
	$content.=("</div>");
	$content.=("</div>");
	$content.=("</div>");
	$content.="</form>";
?>