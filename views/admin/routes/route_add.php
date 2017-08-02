<?php

	if(isset($parameters[0])){
		$page_id=$parameters[0];
	}else{
		$page_id=0;
	}
	
	$page = Page::find($page_id);

	
	$content.="<form role='form' method='post' action='" . pagelink('route_add',$language_id) . "'>";
		$content.="<div class='modal-header'>";
			$content.="<h3>" . $active_pagemeta->title . "</h3>";
		$content.="</div>";

		$content.="<div class='modal-body'>";

		
			$content.="<input type='hidden' name='page_id' value='". $page_id .  "'>";
		
			$content.="<div class='form-group'>";
			$content.="<label for='method' class='control-label'>" . ucfirst(translate('method')) . "</label>";
			$content.="<select class='form-control' name='method' id='method' required>";
			$content.="<option value='GET'>GET</option>";
			$content.="<option value='POST'>POST</option>";
			$content.="</select>";
			$content.="</div>";
			
			$content.="<div class='form-group'>";
			$content.="<label for='page_meta_id' class='control-label'>" . ucfirst(translate('page_meta')) . "</label>";
			$content.="<select class='form-control' name='page_meta_id' id='page_meta_id' required>";
			
			$pagemetas = $page->pagemetas;
			
			foreach($pagemetas as $pagemeta)
			{
				$content.="<option value='" . $pagemeta->id . "'>" . $pagemeta->name . " (".$pagemeta->language->shortname.")</option>";
			}
			
			$content.="</select>";
			$content.="</div>";
			
			
			$content.="<div class='form-group'>";
			$content.="<label for='uri' class='control-label'>" . ucfirst(translate('uri')) . "</label>";
			$content.="<input name='uri' id='uri' type='uri' class='form-control' value=''/>";

			$content.="</div>";
			
			$content.="<div class='form-group'>";
			$content.="<label for='controller_function' class='control-label'>" . ucfirst(translate('controller_function')) . "</label>";
			$content.="<input name='controller_function' id='controller_function' type='text' class='form-control' value=''/>";

			$content.="</div>";
	
			$content.="<div class='form-group'>";
			$content.="<label><input name='load_default_view' type='checkbox' id='load_default_view' >" . ucfirst(translate('load_default_view')) . "</label>";
			$content.="</div>";
			
			
		$content.="</div>";

		$content.="<div class='modal-footer'>";
			$content.="<button type='submit' class='btn btn-primary'>". ucfirst(translate("add")) ."</button>";
			$content.="<button type='button' class='btn btn-secondary' data-dismiss='modal'>" . ucfirst(translate("close")) . "</button>";
		$content.="</div>";
	$content.="</form>";
	

	
?>