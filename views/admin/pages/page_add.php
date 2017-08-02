<?php
	$content.="<form id='order' class='form-horizontal' role='form' data-toggle='validator' method='POST'>";
	$content.="<div class='panel panel-default'>";
	$content.="<div class='panel-heading'>" . ucfirst(translate('page_add')) . "</div>";
	$content.="<div class='panel-body'>";
	$content.="<input type='hidden' name='form_action' value='page_add'/>";
	
	//REFERENCE
	$content.="<div class='form-group'>";
	$content.="<label for='reference' class='col-md-4 control-label'>" . ucfirst(translate('reference')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<input name='reference' id='reference' type='text' class='form-control' required/>";
	$content.="</div>";
	$content.="</div>";
	//END
	
	$content.="<div class='form-group'>";
	$content.="<label for='parent_id' class='col-md-4 control-label'>" . ucfirst(translate('parent_page')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<select name='parent_id' id='parent_id' class='form-control select2'>";
	$content.='<option value="0"></option>';
	$pages = Page::all()->sortBy('reference');
	foreach($pages as $page){
		$content.="<option value='" . $page->id . "'>" . $page->reference . "</option>";
	}
	
	$content.="</select>";
	$content.="</div>";
	$content.="</div>";
	
	//THEME
	$content.="<div class='form-group'>";
	$content.="<label for='parent_id' class='col-md-4 control-label'>" . ucfirst(translate('theme')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<select name='theme_id' id='theme_id' class='form-control select2'>";
	$content.="<option></option>";
	$themes = Theme::all();
	foreach($themes as $theme){
		$content.="<option value='" . $theme->id . "'>" . $theme->name . "</option>";
	}
	
	$content.="</select>";
	$content.="</div>";
	$content.="</div>";
	//END 
	
	$languages = Language::all();
			
	foreach($languages as $language)
	{
		$content.="<div class='form-group'>";
		$content.="<label for='url' class='col-md-4 control-label'>" . ucfirst(translate('url') . " " . $language->shortname) . "</label>";
		$content.="<div class='col-md-6'>";
		$content.="<input type='text' class='form-control' name='url[" . $language->id ."]' id='url_" . $language->id . "'/>";
		$content.="</div>";
		$content.="</div>";
	}
	
	//CUSTOM_CSS
	
	$content.="<div class='form-group'>";
	$content.="<label for='custom_css' class='col-md-4 control-label'>" . ucfirst(translate('custom_css')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<textarea name='custom_css' id='custom_css' type='text' class='form-control'></textarea>";
	$content.="</div>";
	$content.="</div>";
	
	//END 
	
	//CUSTOM_JS
	
	$content.="<div class='form-group'>";
	$content.="<label for='custom_js' class='col-md-4 control-label'>" . ucfirst(translate('custom_js')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<textarea name='custom_js' id='custom_js' type='text' class='form-control'></textarea>";
	$content.="</div>";
	$content.="</div>";
	
	//END 
	
	
	//ACTIVE
	
	$content.="<div class='form-group'>";
	$content.="<div class='col-md-6 col-md-offset-4'>";
    $content.="<div class='checkbox'>";
	$content.="<label><input type='checkbox' name='active' id='active' checked/>" . ucfirst(translate('page_active')) . "</label>";
	$content.="</div>";
   	$content.="</div>";
	$content.="</div>";
	//END 
	
	
	//SHOW IN MENU
	
	$content.="<div class='form-group'>";
	$content.="<div class='col-md-6 col-md-offset-4'>";
    $content.="<div class='checkbox'>";
	$content.="<label><input type='checkbox' name='show_in_menu' id='show_in_menu' checked/>" . ucfirst(translate('show_in_menu')) . "</label>";
	$content.="</div>";
   	$content.="</div>";
	$content.="</div>";
	//END 
	
	//LOGIN REQUIRED
	
	$content.="<div class='form-group'>";
	$content.="<div class='col-md-6 col-md-offset-4'>";
    $content.="<div class='checkbox'>";
	$content.="<label><input type='checkbox' name='login_required' id='login_required'/>" . ucfirst(translate('login_required')) . "</label>";
	$content.="</div>";
   	$content.="</div>";
	$content.="</div>";
	//END 
	
	//PRESENTATION_ORDER
	$content.="<div class='form-group'>";
	$content.="<label for='presentation_order' class='col-md-4 control-label'>" . ucfirst(translate('presentation_order')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<input name='presentation_order' id='presentation_order' type='number' value='0' class='form-control'/>";
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
	
	$script.="function UpdateUrls(){
		var postdata = 'parent_id=' + $('#parent_id').val();
		$.ajax({
			type: 'POST',
			url: '" . actionlink('PageController@page_urls') . "',
			data: postdata,
			success: function(result){ 
				$.each(result,function(language_id,url){ $('#url_' + language_id).val(url + '/' + $('#reference').val()); });
			},
			dataType: 'json'
		});
	}";
	
	$script.="$('#parent_id').on('change',function(){
		
		UpdateUrls();
		
	});";
	
	$script.="$('#reference').on('change',function(){
		
		UpdateUrls();
		
	});";
?>