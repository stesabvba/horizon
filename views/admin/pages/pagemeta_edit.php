<?php
	
	if(isset($parameters[0])){
		$pagemeta_id=$parameters[0];
	}else{
		$pagemeta_id=0;
	}
	
	$pagemeta = PageMeta::find($pagemeta_id);
	
	
	$content.="<form id='order' class='form-horizontal' role='form' data-toggle='validator' method='POST'>";
	$content.="<div class='panel panel-default'>";
	$content.="<div class='panel-heading'>" . ucfirst(translate('pagemeta_add')) . "</div>";
	$content.="<div class='panel-body'>";
	$content.="<input type='hidden' name='form_action' value='pagemeta_edit'/>";
	$content.="<input type='hidden' name='pagemeta_id' value='$pagemeta_id'/>";

	
	//PAGE
	$content.="<div class='form-group'>";
	$content.="<label for='page_id' class='col-md-4 control-label'>" . ucfirst(translate('page')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<select name='page_id' id='page_id' class='form-control' disabled>";
	$content.="<option></option>";
	$pages = Page::all();
	foreach($pages as $page){
		if($page->id==$pagemeta->page->id){
			$content.="<option value='" . $page->id . "' selected>" . $page->reference . "</option>";
		}else{
			$content.="<option value='" . $page->id . "'>" . $page->reference . "</option>";
		}
		
	}
	
	$content.="</select>";
	$content.="</div>";
	$content.="</div>";
	//END
	
	//NAME
	$content.="<div class='form-group'>";
	$content.="<label for='name' class='col-md-4 control-label'>" . ucfirst(translate('name')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<input name='name' id='name' type='text' class='form-control' value='" . $pagemeta->name ."' required/>";
	$content.="</div>";
	$content.="</div>";
	//END
	

	
	//TITLE
	$content.="<div class='form-group'>";
	$content.="<label for='title' class='col-md-4 control-label'>" . ucfirst(translate('title')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<input name='title' id='title' type='text' class='form-control' value='" . $pagemeta->title ."' required/>";
	$content.="</div>";
	$content.="</div>";
	//END
	
	//DESCRIPTION
	
	$content.="<div class='form-group'>";
	$content.="<label for='description' class='col-md-4 control-label'>" . ucfirst(translate('description')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<textarea name='description' id='description' type='text' rows=10 class='form-control'>" . $pagemeta->description ."</textarea>";
	$content.="</div>";
	$content.="</div>";
	
	//END 
	
	//KEYWORDS
	
	$content.="<div class='form-group'>";
	$content.="<label for='keywords' class='col-md-4 control-label'>" . ucfirst(translate('keywords')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<textarea name='keywords' id='keywords' type='text' rows=10 class='form-control'>" . $pagemeta->keywords ."</textarea>";
	$content.="</div>";
	$content.="</div>";
	
	//END
	
	
	//LANGUAGE
	$content.="<div class='form-group'>";
	$content.="<label for='parent_id' class='col-md-4 control-label'>" . ucfirst(translate('language')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<select name='language_id' id='language_id' class='form-control' disabled>";
	$content.="<option></option>";
	$languages = Language::all();
	foreach($languages as $language){
		if($pagemeta->language_id==$language->id){
			$content.="<option value='" . $language->id . "' selected>" . $language->name . "</option>";
		}else{
			$content.="<option value='" . $language->id . "'>" . $language->name . "</option>";
		}
		
	}
	
	$content.="</select>";
	$content.="</div>";
	$content.="</div>";
	//END 
	
	//default_view
	$content.="<div class='form-group'>";
	$content.="<label for='view_id' class='col-md-4 control-label'>" . ucfirst(translate('default_view')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<select name='view_id' id='view_id' class='form-control'>";
	$content.="<option value='0'></option>";
	$views = View::all();
	foreach($views as $view){
		if($pagemeta->view_id==$view->id){
			$content.="<option value='" . $view->id . "' selected>" . $view->name . "</option>";
		}else{
			$content.="<option value='" . $view->id . "'>" . $view->name . "</option>";
		}
		
	}
	
	$content.="</select>";
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