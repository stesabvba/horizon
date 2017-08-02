<?php
	if(isset($parameters[0])){
		$menu_id=$parameters[0];
	}else{
		$menu_id=0;
	}
	function ShowMenuItems($language_id,$menu_id,$parent_id)
	{
		$result="<ul>";
		$items = MenuItem::where('menu_id',$menu_id)->where('parent_id',$parent_id)->where('language_id',$language_id)->orderBy('presentation_order')->get();
		
		$edit_link = pagelink('menu_item_edit',$language_id);
		$delete_link = pagelink('menu_item_delete',$language_id);
		foreach($items as $item)
		{
		
			if($item->alternate_uri!=''){
				$result.="<li style='height: 40px;'>" . $item->menu_text . " (" . $item->alternate_uri . ")";
			}else{
				$result.="<li style='height: 40px;'>" . $item->menu_text;
			}
			
			$result.=" <a href='$edit_link/" . $item->id ."' data-toggle='modal' data-target='#modal' class='btn btn-default'>" . ucfirst(translate('edit')) . '</a>';
			$result.=" <a href='$delete_link/" . $item->id ."' data-toggle='modal' data-target='#modal' class='btn btn-default'>" . ucfirst(translate('delete')) . '</a>';
			$result.="</li>";
			
			$result.=ShowMenuItems($language_id,$menu_id,$item->id);
		}
		
		$result.="</ul>";
		
		return $result;
		
	}
	$menu = Menu::find($menu_id);
	
	$actionlink = actionlink('MenuController@menu_edit');
	
	$content.="<div class='row'>";
	
	$content.="<div class='col-md-12'>";

	$content.="<form id='order' class='form-horizontal' role='form' data-toggle='validator' method='POST' action='$actionlink'>";
	
	$content.="<div class='panel panel-default'>";
	$content.="<div class='panel-heading'>" . ucfirst(translate('menu_edit')) . "</div>";
	$content.="<div class='panel-body'>";
	
	$content.="<input name='menu_id' type='hidden' value='$menu_id' />";
	
	//REFERENCE
	$content.="<div class='form-group'>";
	$content.="<label for='name' class='col-md-1 control-label'>" . ucfirst(translate('name')) . "</label>";
	$content.="<div class='col-md-11'>";
	$content.="<input name='name' id='name' type='text' class='form-control' value='" . $menu->name . "' required/>";
	$content.="</div>";
	$content.="</div>";
	//END
	
	
	
	$content.="<div class='form-group'>";
	$content.="<div class='col-md-11 col-md-offset-1'>";
	$content.="<button type='submit' class='btn btn-default'>" . ucfirst(translate("update")) . "</button>";
	$content.="</div>";
	$content.="</div>";
	
	$content.=("</div>");
	$content.=("</div>");

	$content.="</form>";
	
	$content.=("</div>");
	$content.=("</div>");
	
	$content.="<div class='row'>";
	
	$content.="<div class='col-md-12'>";
	
	$content.="<div class='panel panel-default'>";
	$content.="<div class='panel-heading'>" . ucfirst(translate('menu_items')) . "</div>";
	$content.="<div class='panel-body'>";
	
	$menu_item_add_link = pagelink('menu_item_add',$language_id) . "/" . $menu->id;
	
	$content.="<a href='$menu_item_add_link' data-toggle='modal' data-target='#modal' class='btn btn-default'>" . ucfirst(translate('add')) . "</a>";
	
	$languages = Language::all();
	
	foreach($languages as $language)
	{
		$content.="<h2>" . strtoupper($language->shortname) . "</h2>";
		$content.=ShowMenuItems($language->id,$menu_id,0);
	}
	
	

	
	$content.="</ul>";
	
	$content.=("</div>");
	$content.=("</div>");
	
	
	$content.=("</div>");
	$content.=("</div>");

?>