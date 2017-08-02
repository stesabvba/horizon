<?php
	$page_id = $parameters[0];
	
	$editpage = Page::find($page_id);
	
	if($editpage==null){
		
		header("Location: " . pagelink('pages',$language_id));
		
	}

	$content.="<form id='order' class='form-horizontal' role='form' data-toggle='validator' method='POST'>";
	$content.="<div class='panel panel-default'>";
	$content.="<div class='panel-heading'>" . ucfirst(translate('page_edit')) . "</div>";
	$content.="<div class='panel-body'>";
	$content.="<input type='hidden' name='form_action' value='page_edit'/>";
	$content.="<input type='hidden' name='page_id' value='" . $editpage->id . "'/>";
	//REFERENCE
	$content.="<div class='form-group'>";
	$content.="<label for='reference' class='col-md-4 control-label'>" . ucfirst(translate('reference')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<input name='reference' id='reference' type='text' class='form-control' value='" . $editpage->reference . "' required/>";
	$content.="</div>";
	$content.="</div>";
	//END
	
	$content.="<div class='form-group'>";
	$content.="<label for='parent_id' class='col-md-4 control-label'>" . ucfirst(translate('parent_page')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<select name='parent_id' id='parent_id' class='form-control select2'>";
	$content.="<option value='0'></option>";
	$pages = Page::all();
	foreach($pages as $page){
		if($editpage->parent_id==$page->id){
			$content.="<option value='" . $page->id . "' selected>" . $page->reference . "</option>";
		}else{
			$content.="<option value='" . $page->id . "'>" . $page->reference . "</option>";
		}
		
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
		if($editpage->theme_id==$theme->id){
			$content.="<option value='" . $theme->id . "' selected>" . $theme->name . "</option>";
		}else{
			$content.="<option value='" . $theme->id . "'>" . $theme->name . "</option>";	
		}
		
	}
	
	$content.="</select>";
	$content.="</div>";
	$content.="</div>";
	//END 
	
	$languages = Language::all();
			
	foreach($languages as $language)
	{
		$pagemeta = $editpage->pagemetas()->where('language_id',$language->id)->first();

		if($pagemeta!=null){
			$value = $pagemeta->defaulturi();
		}else{
			$value = "";
		}
		$content.="<div class='form-group'>";
		$content.="<label for='url' class='col-md-4 control-label'>" . ucfirst(translate('default_url') . " " . $language->shortname) . "</label>";
		$content.="<div class='col-md-6'>";
		$content.="<input type='text' class='form-control' name='url[" . $language->id ."]' id='url_" . $language->id . "' value='$value'/>";
		$content.="</div>";
		$content.="</div>";
	}
	
	//CUSTOM_CSS
	
	$content.="<div class='form-group'>";
	$content.="<label for='custom_css' class='col-md-4 control-label'>" . ucfirst(translate('custom_css')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<textarea name='custom_css' id='custom_css' type='text' class='form-control'>". $editpage->custom_css . "</textarea>";
	$content.="</div>";
	$content.="</div>";
	
	//END 
	
	//CUSTOM_JS
	
	$content.="<div class='form-group'>";
	$content.="<label for='custom_js' class='col-md-4 control-label'>" . ucfirst(translate('custom_js')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<textarea name='custom_js' id='custom_js' type='text' class='form-control'>". $editpage->custom_js ."</textarea>";
	$content.="</div>";
	$content.="</div>";
	
	//END 
	
	
	//ACTIVE
	
	$content.="<div class='form-group'>";
	$content.="<div class='col-md-6 col-md-offset-4'>";
    $content.="<div class='checkbox'>";
	if($editpage->active==1){
		$content.="<label><input type='checkbox' name='active' id='active' checked/>" . ucfirst(translate('page_active')) . "</label>";
	}else{
		$content.="<label><input type='checkbox' name='active' id='active' />" . ucfirst(translate('page_active')) . "</label>";	
	}
	$content.="</div>";
   	$content.="</div>";
	$content.="</div>";
	//END 
	
	
	//SHOW IN MENU
	
	$content.="<div class='form-group'>";
	$content.="<div class='col-md-6 col-md-offset-4'>";
    $content.="<div class='checkbox'>";
	if($editpage->show_in_menu==1){
		$content.="<label><input type='checkbox' name='show_in_menu' id='show_in_menu' checked/>" . ucfirst(translate('show_in_menu')) . "</label>";
	}else{
		$content.="<label><input type='checkbox' name='show_in_menu' id='show_in_menu' />" . ucfirst(translate('show_in_menu')) . "</label>";
	}
	$content.="</div>";
   	$content.="</div>";
	$content.="</div>";
	//END 
	
	//LOGIN REQUIRED
	
	$content.="<div class='form-group'>";
	$content.="<div class='col-md-6 col-md-offset-4'>";
    $content.="<div class='checkbox'>";
	if($editpage->login_required==1){
		$content.="<label><input type='checkbox' name='login_required' id='login_required' checked/>" . ucfirst(translate('login_required')) . "</label>";
	}else{
		$content.="<label><input type='checkbox' name='login_required' id='login_required'/>" . ucfirst(translate('login_required')) . "</label>";
	}
	$content.="</div>";
   	$content.="</div>";
	$content.="</div>";
	//END 
	
	//PRESENTATION_ORDER
	$content.="<div class='form-group'>";
	$content.="<label for='presentation_order' class='col-md-4 control-label'>" . ucfirst(translate('presentation_order')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<input name='presentation_order' id='presentation_order' type='number' value='" . $editpage->presentation_order . "' class='form-control'/>";
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
	$content.=("</div>");
	$content.="</form>";
	
	$content.="<div class='panel panel-default'>";
	$content.="<div class='panel-heading'>" . ucfirst(translate('routes')) . "</div>";
	$content.="<div class='panel-body'>";
	
	$content.="<table class='table'>";
	$content.="<tr>";
	$content.="<th>" . ucfirst(translate('language')) . "</th>";
	$content.="<th>" . ucfirst(translate('method')) . "</th>";
	$content.="<th>" . ucfirst(translate('url')) . "</th>";
	$content.="<th>" . ucfirst(translate('controller_function')) . "</th>";
	$content.="<th>" . ucfirst(translate('copy')) . "</th>";
	$content.="<th>" . ucfirst(translate('edit')) . "</th>";
	$content.="<th>" . ucfirst(translate('delete')) . "</th>";
	$content.="</tr>";
	$pagemetas = $editpage->pagemetas;
	
	$pagelink_edit = pagelink('route_edit',$language_id);
	$pagelink_delete = pagelink('route_delete',$language_id);
	$pagelink_copy = pagelink('route_copy',$language_id);
	
	foreach($pagemetas as $pagemeta){
		
		$routes = $pagemeta->routes;
		
		foreach($routes as $route){
			
			$content.="<tr>";
			$content.="<td>" . $pagemeta->language->shortname . "</td>";
			$content.="<td>" . $route->method . "</td>";
			$content.="<td>" . $route->uri . "</td>";
			$content.="<td>" . $route->controller_function . "</td>";
			$content.="<td><a href='" . $pagelink_copy . "/" . $route->id . "' class='btn btn-default' data-toggle='modal' data-target='#modal'>" . ucfirst(translate('copy'))  . "</a></td>";
			$content.="<td><a href='" . $pagelink_edit . "/" . $route->id . "' class='btn btn-default' data-toggle='modal' data-target='#modal'>" . ucfirst(translate('edit'))  . "</a></td>";
			$content.="<td><a href='" . $pagelink_delete . "/" . $route->id . "' class='btn btn-default' data-toggle='modal' data-target='#modal'>" . ucfirst(translate('delete'))  . "</a></td>";

			$content.="</tr>";
			
		}
	}
	
	$content.="</table>";
	
	$content.="<a href='" . pagelink('route_add',$language_id) . "/" . $editpage->id . "' class='btn btn-default' data-toggle='modal' data-target='#modal'>" . ucfirst(translate('add'))  . "</a>";
	
	$content.="</div>";
	$content.="</div>";

	
	
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