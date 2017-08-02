<?php
$pages = $template_vars['pages'];
$paginator = $template_vars['paginator'];

$can_edit_page = $active_user->can("view_page_edit_page");
$can_delete_page = $active_user->can("view_page_delete_page");

$content.="<div class='col-md-12'>";

$content.=$paginator;





$content.= "<table class='table'>";



$languages = Language::all();

$content.=("<tr>");
$content.=("<th><a class='column' href='#'>" . ucfirst(translate("id")) . "</a></th>");
$content.=("<th>" . ucfirst(translate("reference")) . "</th>");

foreach($languages as $language){
	$content.=("<th>" . $language->shortname . "</th>");
}

if($can_edit_page==1)
{
	$content.=("<th>" . ucfirst(translate("edit")) . "</th>");	
}
if($can_delete_page==1)
{
	$content.=("<th>" . ucfirst(translate("delete")) . "</th>");
}
$content.=("</tr>");

$pagelink_edit = pagelink('page_edit',$language_id);
$pagelink_delete = pagelink('page_delete',$language_id);
$pagemeta_edit = pagelink('pagemeta_edit',$language_id);
$pagemeta_add = pagelink('pagemeta_add',$language_id);
foreach($pages as $page){
	
	$content.=("<tr>");
	$content.=("<td>" . $page->id . "</td>");
	$content.=("<td>" . $page->reference . "</td>");
	
	foreach($languages as $language){
	
		$pagemeta = $page->pagemetas->where('language_id',$language->id)->first();
		
		
		if($pagemeta!=null){
			$content.=("<td>");
			$content.=("<form method='post'>");

			$content.=("<a class='btn btn-default btn-xs' href='" . $pagemeta_edit . "/" . $pagemeta->id . "'><i class='glyphicon glyphicon-edit'></i><img src='" . $site_config['site_url']->value . "img/flags/". $language->shortname .".png' /></a>");
			
			$content.=("</td>");
		}else{
			$content.=("<td>");

			$content.=("<a class='btn btn-default btn-xs' href='" . $pagemeta_add . '/' . $page->id . '/' . $language->id . "'><i class='glyphicon glyphicon-plus'></i><img src='" . $site_config['site_url']->value . "img/flags/". $language->shortname .".png' /></a>");

			$content.=("</td>");
		}
		
	
		
	}
	
	if($can_edit_page==1)
	{
		$content.="<td><a class='btn btn-default' href='" . $pagelink_edit . '/' . $page->id .  "'>" . ucfirst(translate("edit")) ."</a></td>";
	}
	
	if($can_delete_page==1)
	{
	$content.="<td><a class='btn btn-default' href='" . $pagelink_delete . '/' . $page->id .  "'>" . ucfirst(translate("delete")) ."</a></td>";
	}
	$content.=("</tr>");
	
	
}

$content.= "</table>";
$content.= "</div>";

?>
