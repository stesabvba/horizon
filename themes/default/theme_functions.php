<?php

function buildLanguageMenu(){
	global $language_id,$active_page, $parameters;
	$languages = Language::where('active',1)->get();

	$lang_menu="";
	foreach($languages as $language){

		if($language->id==$language_id){
			$current = "class='active'";
		}else{
			$current = "";
		}
		
		if($active_page->pagemetas->where('language_id',$language->id)->first()!=null){ //if pagemeta exists in the language
			$lang_menu.="<li $current><a href='" . pagelink($active_page->reference,$language->id,'GET',null,$parameters) . "'>" . strtoupper($language->shortname) . "</a></li>";
		}
		
		
	}
	
	return $lang_menu;
}



function buildThemeMenu($menu_id,$parent_id){
	global $site_config,$language_id,$active_pagemeta, $active_user;
	$result = "";
	
	$menu_items = MenuItem::where('menu_id',$menu_id)->where('language_id',$language_id)->where('parent_id',$parent_id)->orderBy('presentation_order')->get();

	
	foreach($menu_items as $menu_item)
	{
		
		$pagemeta = $menu_item->pagemeta;
		$class='';
		if($pagemeta!=null){
			$uri = $site_config['site_url']->value . $pagemeta->defaulturi();
			
			$page = $pagemeta->page;
			
			if(!$active_user->can('view_' . $page->reference ."_page")){				
				//echo 'view_' . $page->reference .'_page => geen toestemming<br />';
			
			}

			if($active_pagemeta->id == $pagemeta->id){
				$class="active";
			}
 		}else{
			$uri = $menu_item->alternate_uri;
		}
		
		if(MenuItem::where('menu_id',$menu_id)->where('language_id',$language_id)->where('parent_id',$menu_item->id)->count()>0){
			$result.="<li class='$class dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>" . $menu_item->menu_text . " <span class='caret'></span></a>";
				$result.="<ul class='dropdown-menu'>";
				$result.=buildThemeMenu($menu_id,$menu_item->id);
				$result.="</ul>";
			$result.="</li>";						
		}else{
			//$str_debug = $menu_item->id.' ';
			$str_debug = '';
			$result.= "<li class='$class'><a href='$uri'>" .$str_debug. $menu_item->menu_text . "</a></li>";
		}
	}
		
	return $result;
}

?>