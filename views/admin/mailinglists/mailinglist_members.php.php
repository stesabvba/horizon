<?php

if(isset($parameters[0])){
	$mailinglist_id=$parameters[0];
}else{
	$mailinglist_id=0;
}

$mailinglist = Mailinglist::find($mailinglist_id);

if($mailinglist==null){
	header("Location:" . pagelink("mailinglists",$language_id));
}

$content.="<h3>" . ucfirst(translate("members_for")) . " ".  $mailinglist->name . "</h3>";	
	
$content.= "<table class='table'>";

$mailinglistmembers = $mailinglist->members;
$content.=("<th>" . translate("id") . "</th>");
$content.=("<th>" . translate("name") . "</th>");
$content.=("<th>" . translate("language") . "</th>");

$content.=("<th>" . translate("edit") . "</th>");
$content.=("<th>" . translate("delete") . "</th>");
$content.=("</tr>");

$pagelink_edit = pagelink('mailinglist_member_edit',$language_id);
$pagelink_delete = pagelink('mailinglist_member_delete',$language_id);

foreach($mailinglistmembers as $mailinglistmember){
	
	$content.=("<tr>");
	$content.=("<td>" . $mailinglistmember->id . "</td>");
	$content.=("<td>" . $mailinglistmember->user->firstname . "</td>");
	$content.=("<td>" . $mailinglistmember->language->shortname. "</td>");

	$content.="<td><a href='" . $pagelink_edit . "/" . $mailinglistmember->id . "' class='btn btn-default' data-toggle='modal' data-target='#modal'>" . ucfirst(translate('edit'))  . "</a></td>";
	$content.="<td><a href='" . $pagelink_delete . "/" . $mailinglistmember->id . "' class='btn btn-default' data-toggle='modal' data-target='#modal'>" . ucfirst(translate('delete'))  . "</a></td>";
	$content.=("</tr>");
	
	
}

$content.= "</table>";
$content.="<a href='" . pagelink('mailinglist_member_add',$language_id) . '/' . $mailinglist->id .  "' class='btn btn-default' data-toggle='modal' data-target='#modal'>" . ucfirst(translate('add'))  . "</a>";

?>