<?php
	if(isset($parameters[0])){
		$menu_id=$parameters[0];
	}else{
		$menu_id=0;
	}
	

	
	$content.="<form role='form' method='post' action='". actionlink('MenuController@menu_item_add',$active_pagemeta->id) . "'>";
		$content.="<div class='modal-header'>";
			$content.="<h3>" . $active_pagemeta->title . "</h3>";
		$content.="</div>";

		$content.="<div class='modal-body'>";

			$content.="<input type='hidden' name='menu_id' value='". $menu_id .  "'>";
			
			$content.="<div class='form-group'>";

			$content.="<label for='parent_id' class='control-label'>" . ucfirst(translate('parent_menu_item')) . "</label>";
			$content.="<select name='parent_id' id='parent_id' class='form-control select2' required>";
			
			$content.="<option value='0'>" . translate('no_parent_selected') . "</option>";
			
			$menu_items = MenuItem::where('menu_id',$menu_id)->get();
			
			foreach($menu_items as $menu_item)
			{
				$content.="<option value='" . $menu_item->id . "'>" . $menu_item->menu_text . " (".$menu_item->id.")</option>";
			}
			
			$content.="</select>";
			$content.="</div>";
		
			$content.="<div class='form-group'>";
			$content.="<label for='language_id' class='control-label'>" . ucfirst(translate('language')) . "</label>";
			$content.="<select name='language_id' id='language_id' class='form-control' required>";
			
			$content.="<option></option>";
			
			$languages = Language::all();
			
			foreach($languages as $language)
			{
				$content.="<option value='" . $language->id . "'>" . $language->name . "</option>";
			}
			
			$content.="</select>";
			$content.="</div>";
			
			
			$content.="<div class='form-group'>";
			$content.="<label for='page_meta_id' class='control-label'>" . ucfirst(translate('page_meta')) . "</label>";
			$content.="<select name='page_meta_id' id='page_meta_id' class='select2 form-control'>";
			$content.="<option></option>";
			$pagemetas = PageMeta::orderBy('name')->get();
			
			foreach($pagemetas as $pagemeta)
			{
				$lang_id = $pagemeta->language_id;
				$page_reference = $pagemeta->page->reference;
				
				$content.="<option value='" . $pagemeta->id . "' style='display:none;' class='pagemeta pagemeta_$lang_id' >" . $pagemeta->name . " (" . $page_reference . ") (".$pagemeta->id.")</option>";
			}
			
			$content.="</select>";
			$content.="</div>";
			
			$content.="<div class='form-group'>";
			$content.="<label for='alternate_uri' class='control-label'>" . ucfirst(translate('alternate_uri')) . "</label>";
			$content.="<input type='text' class='form-control' name='alternate_uri'/>";
			$content.="</div>";
			
			$content.="<div class='form-group'>";
			$content.="<label for='menu_text' class='control-label'>" . ucfirst(translate('menu_text')) . "</label>";
			$content.="<input type='text' class='form-control' name='menu_text' id='menu_text' required/>";
			$content.="</div>";
			$content.="<div class='form-group'>";
			$content.="<label for='presentation_order' class='control-label'>" . ucfirst(translate('presentation_order')) . "</label>";
				$content.="<input type='number' class='form-control' name='presentation_order' value='0' required/>";
			$content.="</div>";

			
			
		$content.="</div>";

		$content.="<div class='modal-footer'>";
			$content.="<button type='submit' class='btn btn-primary'>". ucfirst(translate("add")) ."</button>";
			$content.="<button type='button' class='btn btn-secondary' data-dismiss='modal'>" . ucfirst(translate("close")) . "</button>";
		$content.="</div>";
	$content.="</form>";
	
	/*$script.="$('#language_id').on('change',function(){ 
		var language = $('#language_id').val(); 
		$('.pagemeta').hide(); 
		$('.pagemeta_' + language).show();
		$('#page_meta_id').val('');
	});

	

	";*/
	
	$script.="$('#page_meta_id').select2(); $('#page_meta_id').on('change',function(){ $('#menu_text').val($('#page_meta_id option:selected').text());});";

?>