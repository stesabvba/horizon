<?php

if($active_user->can('edit_translations_inline')){
	$content.="<div class='panel panel-default'>";
	$content.="<div class='panel-heading'>" . ucfirst(translate('inline_translations')) . "</div>";
	$content.="<div class='panel-body'>";

	$content.=translate('inline_translation_status') . " " . YesNo($site_config['inline_translations_active']->value);

	$content.="<form method='post' action='" . actionlink('TranslationController@toggle_inline_translations',$active_pagemeta->id) . "'>";
	$content.="<input type='hidden' name='form_action' value='toggle_inline_translations'>";
	$content.="<button class='btn btn-default'>" . translate('toggle') . "</button>";
	$content.="</form>";

	$content.="</div>";
	$content.="</div>";

}



$content.="<div class='panel panel-default'>";
$content.="<div class='panel-heading'>" . ucfirst(translate('translations')) . "</div>";
$content.="<div class='panel-body'>";
		
$content.= "<table id='translations' class='table table-striped'>";
$content.=("<thead>");
$content.=("<tr>");
$content.=("<th>" . ucfirst(translate("id")) . "</th>");
$content.=("<th>" . ucfirst(translate("reference")) . "</th>");
$content.=("<th>" . ucfirst(translate("language")) . "</th>");
$content.=("<th>" . ucfirst(translate("type")) . "</th>");
$content.=("<th>" . ucfirst(translate("translation")) . "</th>");
$content.=("<th>" . ucfirst(translate("edit")) . "</th>");
$content.=("<th>" . ucfirst(translate("delete")) . "</th>");
$content.=("</tr>");
$content.=("</thead>");
$content.= "</table>";

$content.="</div>";
$content.="</div>";


$data_columns = "{'name': 'id', 'data': 'id'},{'name': 'reference', 'data': 'reference'},{'name': 'language_id', data: 'language', 'searchable':false},{name: 'type', 'data': 'type'},{'name':'translation', 'data': 'translation'},{'data': 'editlink', 'searchable': false, 'orderable': false},{'data': 'deletelink', 'searchable': false, 'orderable': false }";
$script.=Paginate("translations",actionlink('TranslationController@translations_list',$active_pagemeta->id),$data_columns);


echo '<a class="btn btn-default" data-toggle="modal" data-target="#modal" href="'.pagelink('translation_add',$language_id).'">'.ucfirst(translate('translation_add')).'</a>';
?>