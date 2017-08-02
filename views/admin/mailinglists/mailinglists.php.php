<?php
$content.= "<table class='table'>";

$mailinglists = Mailinglist::all();
$content.=("<th>" . ucfirst(translate("id")) . "</th>");
$content.=("<th>" . ucfirst(translate("name")) . "</th>");
$content.=("<th>" . ucfirst(translate("enduser")) . "</th>");
$content.=("<th>" . ucfirst(translate("members")) . "</th>");
$content.=("<th>" . ucfirst(translate("messages")) . "</th>");
$content.=("<th>" . ucfirst(translate("edit")) . "</th>");
$content.=("<th>" . ucfirst(translate("delete")) . "</th>");
$content.=("</tr>");

$pagelink_edit = pagelink('mailinglist_edit',$language_id);
$pagelink_delete = pagelink('mailinglist_delete',$language_id);

foreach($mailinglists as $mailinglist){
	
	$content.=("<tr>");
	$content.=("<td>" . $mailinglist->id . "</td>");
	$content.=("<td>" . translate($mailinglist->name) . "</td>");
	$content.=("<td>" . $mailinglist->enduser. "</td>");
	$content.=("<td><a href='" . pagelink('mailinglist_members',$language_id) .  "/" . $mailinglist->id . "'>" . $mailinglist->members()->count() . "</a></td>");
	$content.=("<td><a href='" . pagelink('mailinglist_messages',$language_id) .  "/" . $mailinglist->id . "'>" . $mailinglist->messages()->count() . "</a></td>");
	$content.="<td><a href='" . $pagelink_edit . "/" . $mailinglist->id . "' class='btn btn-default' data-toggle='modal' data-target='#modal'>" . ucfirst(translate('edit'))  . "</a></td>";
	$content.="<td><a href='" . $pagelink_delete . "/" . $mailinglist->id . "' class='btn btn-default' data-toggle='modal' data-target='#modal'>" . ucfirst(translate('delete'))  . "</a></td>";

	$content.=("</tr>");
	
	
}

$content.= "</table>";


$content.="<a href='" . pagelink('mailinglist_add',$language_id) .  "' class='btn btn-default' data-toggle='modal' data-target='#modal'>" . ucfirst(translate('mailinglist_add'))  . "</a>";





?>