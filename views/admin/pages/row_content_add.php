<?php
	if(isset($parameters[0])){
		$row_id=$parameters[0];
	}else{
		$row_id=0;
	}
	
	


$content.="<form role='form' method='post'>";
	$content.="<div class='modal-header'>";
		$content.="<h3>" . $active_pagemeta->title . "</h3>";
	$content.="</div>";

	$content.="<div class='modal-body'>";

		$content.="<input type='hidden' name='form_action' value='row_content_add'>";
		$content.="<input type='hidden' name='row_id' value='". $row_id .  "'>";
		
		$content.="<div class='form-group'>";
		$content.="<label for='module_id' class='control-label'>" . ucfirst(translate('module')) . "</label>";
		
		$content.="<select name='module_id' id='module_id' class='form-control' required>";
		$content.="<option></option>";
		$modules = Module::all();
		foreach($modules as $module){
			
			$content.="<option value='" . $module->id . "'>" . $module->name . "</option>";

		}
		$content.="</select>";

		$content.="</div>";	
		
		$content.="<div class='form-group'>";
		$content.="<label for='content' class='control-label'>" . ucfirst(translate('content')) . "</label>";
		$content.="<input name='content' id='content' class='form-control' type='text' required>";
		$content.="</div>";	
		
		$content.="<div class='form-group'>";
		$content.="<label for='size' class='control-label'>" . ucfirst(translate('size')) . "</label>";
		$content.="<input name='size' id='size' class='form-control' type='number' value='12' min='0' max='12' required>";
		$content.="</div>";	
		
		$content.="<div class='form-group'>";
		$content.="<label for='offset' class='control-label'>" . ucfirst(translate('offset')) . "</label>";
		$content.="<input name='offset' id='offset' class='form-control' type='number' value='0' min='0' max='12' required>";
		$content.="</div>";	
		
		$content.="<div class='form-group'>";
		$content.="<label for='presentation_order' class='control-label'>" . ucfirst(translate('presentation_order')) . "</label>";
		$content.="<input name='presentation_order' id='presentation_order' class='form-control' type='number' value='0' required>";
		$content.="</div>";	
		
				
	$content.="</div>";

	$content.="<div class='modal-footer'>";
		$content.="<button type='submit' class='btn btn-primary'>". ucfirst(translate("add")) ."</button>";
		$content.="<button type='button' class='btn btn-secondary' data-dismiss='modal'>" . ucfirst(translate("close")) . "</button>";
	$content.="</div>";
$content.="</form>";
       
?>