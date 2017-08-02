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

$content.="<h3>" . ucfirst(translate("messages_for")) . " ".  $mailinglist->name . "</h3>";	
	
$content.= "<table class='table'>";

$mailinglistmessages = $mailinglist->messages;
$content.=("<th>" . translate("id") . "</th>");
$content.=("<th>" . translate("name") . "</th>");
$content.=("<th>" . translate("created_at") . "</th>");
$content.=("<th>" . translate("updated_at") . "</th>");
$content.=("<th>" . translate("sent_at") . "</th>");
$content.=("<th>" . translate("edit") . "</th>");
$content.=("<th>" . translate("delete") . "</th>");
$content.=("</tr>");

$pagelink_edit = pagelink('mailinglist_message_edit',$language_id);
$pagelink_delete = pagelink('mailinglist_message_delete',$language_id);

foreach($mailinglistmessages as $mailinglistmessage){
	
	$content.=("<tr>");
	$content.=("<td>" . $mailinglistmessage->id . "</td>");
	$content.=("<td>" . $mailinglistmessage->name . "</td>");
	$content.=("<td>" . $mailinglistmessage->created_at . "</td>");
	$content.=("<td>" . $mailinglistmessage->updated_at . "</td>");
	$content.=("<td>" . $mailinglistmessage->sent_at . "</td>");
	

	$content.="<td><a href='" . $pagelink_edit . "/" . $mailinglistmessage->id . "' class='btn btn-default'>" . ucfirst(translate('edit'))  . "</a></td>";
	$content.="<td><a href='" . $pagelink_delete . "/" . $mailinglistmessage->id . "' class='btn btn-default' data-toggle='modal' data-target='#modal'>" . ucfirst(translate('delete'))  . "</a></td>";
	$content.=("</tr>");
	
	
}

$content.= "</table>";
$content.="<a href='" . pagelink('mailinglist_message_add',$language_id) . '/' . $mailinglist->id .  "' class='btn btn-default'>" . ucfirst(translate('add'))  . "</a>";

?>