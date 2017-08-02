<?php
	function ShowUserRights($id)
	{
		$output="";
		
		$userrights = UserRight::where('parent_id',$id)->get();
		foreach($userrights as $userright){
			
			$output.="<label><input type='checkbox' name='userrights[" . $userright->id . "]'/> " . $userright->name . "</label><br/>";
			
			$output.=ShowUserRights($userright->id);
		}
		
		
		return $output;
	}

	$content.="<form id='order' class='form-horizontal' role='form' data-toggle='validator' method='POST'>";
	$content.="<div class='panel panel-default'>";
	$content.="<div class='panel-heading'>" . ucfirst(translate('userright_add')) . "</div>";
	$content.="<div class='panel-body'>";
	$content.="<input type='hidden' name='form_action' value='profile_add'/>";
	
	//REFERENCE
	$content.="<div class='form-group'>";
	$content.="<label for='name' class='col-md-4 control-label'>" . ucfirst(translate('name')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<input name='name' id='name' type='text' class='form-control' required/>";
	$content.="</div>";
	$content.="</div>";
	//END
	
	//ENDUSER
	
	$content.="<div class='form-group'>";
	$content.="<div class='col-md-6 col-md-offset-4'>";
    $content.="<div class='checkbox'>";
	$content.="<label><input type='checkbox' name='enduser' id='enduser' checked/>" . ucfirst(translate('usergroup_enduser')) . "</label>";
	$content.="</div>";
   	$content.="</div>";
	$content.="</div>";
	//END 
	
	
	//ACTIVE
	
	$content.="<div class='form-group'>";
	$content.="<div class='col-md-6 col-md-offset-4'>";
    $content.="<div class='checkbox'>";
	$content.="<label><input type='checkbox' name='active' id='active' checked/>" . ucfirst(translate('usergroup_active')) . "</label>";
	$content.="</div>";
   	$content.="</div>";
	$content.="</div>";
	//END 
	
	//USERRIGHTS
	$content.="<div class='form-group'>";
	$content.="<label for='name' class='col-md-4 control-label'>" . ucfirst(translate('usergroup_userrights')) . "</label>";
	$content.="<div class='col-md-6'>";
		$content.="<label><input id='select_all' type='checkbox' >" . ucfirst(translate('select_all_userrights')) . "</label><br/>";
	$content.=ShowUserRights(0);
	
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

	$script.="$('#select_all').on('click',function(){ 
	
		var checked = this.checked;
		 if(checked) {
			 $(':checkbox').prop('checked',checked);
		 }else{
			 $(':checkbox').prop('checked',checked);
		 }
	});";
			
?>