<?php

	if(isset($parameters[0])){
		$route_id=$parameters[0];
	}else{
		$route_id=0;
	}
	
	$route = Route::find($route_id);
	
	$pm = $route->pagemeta;
	
	$page = $pm->page;

	$content.="<form role='form' method='post' action='" . pagelink('route_edit',$language_id) . "'>";
		$content.="<div class='modal-header'>";
			$content.="<h3>" . $active_pagemeta->title . "</h3>";
		$content.="</div>";

		$content.="<div class='modal-body'>";

			$content.="<input type='hidden' name='route_id' value='". $route->id .  "'>";
			$content.="<input type='hidden' name='page_id' value='". $page->id .  "'>";
		
			$content.="<div class='form-group'>";
			$content.="<label for='method' class='control-label'>" . ucfirst(translate('method')) . "</label>";
			$content.="<select class='form-control' name='method' id='method' required>";
			
			$methods = array('GET','POST');
			
			foreach($methods as $method){				
				if($route->method==$method){
					$content.="<option value='$method' selected>$method</option>";
				}else{
					$content.="<option value='$method'>$method</option>";
				}
				
			}
			
			
			$content.="</select>";
			$content.="</div>";
			
			$content.="<div class='form-group'>";
			$content.="<label for='page_meta_id' class='control-label'>" . ucfirst(translate('page_meta')) . "</label>";
			$content.="<select class='form-control' name='page_meta_id' id='page_meta_id' required>";
			
			$pagemetas = $page->pagemetas;
			
			foreach($pagemetas as $pagemeta)
			{
				$str_sel = ($pagemeta->id==$route->page_meta_id)?' selected="selected" ':'';
				$content.="<option value='" . $pagemeta->id . "' ".$str_sel.">" . $pagemeta->name . " (".$pagemeta->language->shortname.")</option>";	
			}
			
			$content.="</select>";
			$content.="</div>";
			
			
			$content.="<div class='form-group'>";
			$content.="<label for='uri' class='control-label'>" . ucfirst(translate('uri')) . "</label>";
			$content.="<input name='uri' id='uri' type='uri' class='form-control' value='" . $route->uri . "'/>";

			$content.="</div>";
			
			$content.="<div class='form-group'>";
			$content.="<label for='controller_function' class='control-label'>" . ucfirst(translate('controller_function')) . "</label>";
			$content.="<input name='controller_function' id='controller_function' type='text' class='form-control' value='" . $route->controller_function . "'/>";

			$content.="</div>";
	
			$content.="<div class='form-group'>";
			if($route->load_default_view==1){
				$content.="<label><input name='load_default_view' type='checkbox' id='load_default_view' checked >" . ucfirst(translate('load_default_view')) . "</label>";
			}else{
				$content.="<label><input name='load_default_view' type='checkbox' id='load_default_view' >" . ucfirst(translate('load_default_view')) . "</label>";	
			}
			
			$content.="</div>";
			
			
		$content.="</div>";

		$content.="<div class='modal-footer'>";
			$content.="<button type='submit' class='btn btn-primary'>". ucfirst(translate("update")) ."</button>";
			$content.="<button type='button' class='btn btn-secondary' data-dismiss='modal'>" . ucfirst(translate("close")) . "</button>";
		$content.="</div>";
	$content.="</form>";

?>