<?php
	$breadcrumb.=generatePageBreadCrumb('home');
	$breadcrumb.=generatePageBreadCrumb('manage');
	$breadcrumb.=generatePageBreadCrumb('users');
	$breadcrumb.=generatePageBreadCrumb('user_edit',array($template_vars['user_id']));

	if (!empty($template_vars['tabs'])) {
		$content .= '<ul class="nav nav-tabs">';
		foreach($template_vars['tabs'] as $tab) {
			$cls = strlen(trim($tab['class'])) > 0?' class="active" ':'';
			$content .= '<li role="presentation" '.$cls.'><a href="'.$tab['url'].'">'.$tab['label'].'</a></li>';
		}
		$content .= '</ul>';
	}
	
	$content.="<form id='order' class='form-horizontal' role='form' data-toggle='validator' method='POST'>";
	$content.="<div class='panel panel-default'>";
	$content.="<div class='panel-heading'>" . ucfirst(translate('user_edit')) . "</div>";
	$content.="<div class='panel-body'>";
	$content.="<input type='hidden' name='form_action' value='user_edit'/>";
	$content.="<input type='hidden' name='user_id' value='" . $template_vars['user']->id . "'/>";
	
	//firstname
	$content.="<div class='form-group'>";
	$content.="<label for='firstname' class='col-md-4 control-label'>" . ucfirst(translate('firstname')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<input name='firstname' id='firstname' type='text' class='form-control' value='" . $template_vars['user']->firstname . "' required/>";
	$content.="</div>";
	$content.="</div>";
	//end
	
	//lastname
	$content.="<div class='form-group'>";
	$content.="<label for='lastname' class='col-md-4 control-label'>" . ucfirst(translate('lastname')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<input name='lastname' id='lastname' type='text' class='form-control' value='" . $template_vars['user']->lastname . "' />";
	$content.="</div>";
	$content.="</div>";
	//end
	
	//email
	$content.="<div class='form-group'>";
	$content.="<label for='email' class='col-md-4 control-label'>" . ucfirst(translate('email')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<input name='email' id='email' type='text' class='form-control' value='" . $template_vars['user']->email . "' required/>";
	$content.="</div>";
	$content.="</div>";
	//end
	
	
	//username
/*	$content.="<div class='form-group'>";
	$content.="<label for='username' class='col-md-4 control-label'>" . ucfirst(translate('username')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<input name='username' id='username' type='text' class='form-control' value='" . $template_vars['user']->username . "' required/>";
	$content.="</div>";
	$content.="</div>";*/
	//end
	
	//password
	$content.="<div class='form-group'>";
	$content.="<label for='password' class='col-md-4 control-label'>" . ucfirst(translate('password')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<input name='password' id='password' type='password' class='form-control' value='' />";
	$content.="</div>";
	$content.="</div>";
	//end
	
	$content.="<div class='form-group'>";
	$content.="<label for='communication_language_id' class='col-md-4 control-label'>" . ucfirst(translate('communication_language')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<select name='communication_language_id' id='communication_language_id' class='form-control' required>";
	$content.="<option></option>";
	$languages = Language::where('active',1)->get();
	foreach($languages as $language){
		if($template_vars['user']->communication_language_id==$language->id){
			$content.="<option value='" . $language->id . "' selected>" . $language->name . "</option>";
		}else{
			$content.="<option value='" . $language->id . "'>" . $language->name . "</option>";
		}
			
		
	}
	$content.="</select>";
	$content.="</div>";
	$content.="</div>";

	//profiles
	$content.="<div class='form-group'>";
	$content.="<label for='profile_id' class='col-md-4 control-label'>" . ucfirst(translate('user_profile')) . "</label>";
	$content.="<div class='col-md-6'>";

	$str_disabled = $active_user->has_profile('admin')?'':' disabled="disabled" ';

	$content.="<select name='profile_id' id='profile_id' class='form-control' required ".$str_disabled.">";
	$content.="<option></option>";
	$profiles = Profile::where('active',1)->get();
	foreach($profiles as $profile){
		
		if($template_vars['user']->profile_id==$profile->id){
	
			$content.="<option value='" . $profile->id . "' selected>" . $profile->name . "</option>";
	
		}else{
			$content.="<option value='" . $profile->id . "'>" . $profile->name . "</option>";
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
	if($template_vars['user']->active==1){
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