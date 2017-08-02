<?php
	if(isset($parameters[0])){
		$mailinglist_member_id=$parameters[0];
	}else{
		$mailinglist_member_id=0;
	}
	
	$mailinglistmember = Mailinglistmember::find($mailinglist_member_id);
	
	

$content.="<form role='form' method='post'>";
	$content.="<div class='modal-header'>";
		$content.="<h3>" . $active_pagemeta->title . "</h3>";
	$content.="</div>";

	$content.="<div class='modal-body'>";

		$content.="<input type='hidden' name='form_action' value='mailinglist_member_edit'>";
		$content.="<input type='hidden' name='mailinglist_member_id' value='". $mailinglistmember->id .  "'>";
		
		$content.="<div class='form-group'>";
		$content.="<label for='parent_id' class='col-md-1 control-label'>" . ucfirst(translate('language')) . "</label>";
		
		$content.="<select name='language_id' id='language_id' class='form-control' required>";
		$content.="<option></option>";
		$languages = Language::all();
		foreach($languages as $language){
			if($mailinglistmember->language_id==$language->id){
				$content.="<option value='" . $language->id . "' selected>" . $language->name . "</option>";
			}else{
				$content.="<option value='" . $language->id . "'>" . $language->name . "</option>";
			}
			
		}
		
		$content.="</select>";

		$content.="</div>";	
	$content.="</div>";

	$content.="<div class='modal-footer'>";
		$content.="<button type='submit' class='btn btn-primary'>". ucfirst(translate("update")) ."</button>";
		$content.="<button type='button' class='btn btn-secondary' data-dismiss='modal'>" . ucfirst(translate("close")) . "</button>";
	$content.="</div>";
$content.="</form>";
       
?>