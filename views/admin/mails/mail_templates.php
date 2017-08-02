<?php

$template =  Array();
$template_list = Array();

$file_list = scandir(__DIR__ . "/../../../tinymce_templates/");

$content.= "<table class='table'>";

$mails = Mail::all();
$content.=("<tr>");
$content.=("<th>" . ucfirst(translate("template_title")) . "</th>");
$content.=("<th>" . ucfirst(translate("url")) . "</th>");
$content.=("<th>" . ucfirst(translate("edit")) . "</th>");
$content.=("<th>" . ucfirst(translate("delete")) . "</th>");
$content.=("</tr>");

$pagelink_edit = pagelink('mail_template_edit',$language_id);
$pagelink_delete = pagelink('mail_template_delete',$language_id);

foreach($file_list as $file){
	$split_file = explode(".",$file);
	if($split_file[1] == "html"){
		


		$content.=("<tr>");
		$template['title'] = str_replace("_"," ",$split_file[0]);
		$template['description'] = "";
		$template['url'] = $site_config['site_url']->value . "modules/tinymce_templates/".$file;
		$template_list[] = $template;
		
		$content.=("<td>".$template['title']."</td>");
		$content.=("<td>".$template['url']."</td>");
		$content.=("<td><a class='btn btn-default' href='" . $pagelink_edit . '/' . $split_file[0] .  "'>" . ucfirst(translate("edit")) ."</a></td>");
		$content.=("<td><a data-toggle='modal' data-target='#modal' class='btn btn-default' href='" . $pagelink_delete . '/' . $split_file[0] .  "'>" . ucfirst(translate("delete")) ."</a></td>");
		$content.=("</tr>");
	}
}
$content .= "</table>";
$content.="<a class='btn btn-default' href='"  . pagelink('mail_template_add',$language_id). "'>" . ucfirst(translate('mail_template_add')) . "</a>";

?>