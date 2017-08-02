<?php
$content.= "<table class='table'>";

$mails = Mail::all();
$content.=("<th>" . ucfirst(translate("id")) . "</th>");
$content.=("<th>" . ucfirst(translate("user")) . "</th>");
$content.=("<th>" . ucfirst(translate("from")) . "</th>");
$content.=("<th>" . ucfirst(translate("to")) . "</th>");
$content.=("<th>" . ucfirst(translate("subject")) . "</th>");
$content.=("<th>" . ucfirst(translate("sent_at")) . "</th>");
$content.=("<th>" . ucfirst(translate("send")) . "</th>");
$content.=("<th>" . ucfirst(translate("edit")) . "</th>");
$content.=("<th>" . ucfirst(translate("delete")) . "</th>");
$content.=("</tr>");

$pagelink_edit = pagelink('mail_edit',$language_id);
$pagelink_delete = pagelink('mail_delete',$language_id);

foreach($mails as $mail){
	
	$content.=("<tr>");
	$content.=("<td>" . $mail->id . "</td>");
	if($mail->user!=null){
		$content.=("<td>" . $mail->user->firstname . " " . $mail->user->lastname . "</td>");
	}else{
		$content.=("<td>" . translate("unknown_user") . "</td>");
	}
	
	$content.=("<td>" . $mail->from . "</td>");
	$content.=("<td>" . $mail->to. "</td>");
	$content.=("<td>" . $mail->subject . "</td>");
	$content.=("<td>" . $mail->sent_at. "</td>");

	$content.="<form method='post'>";
	$content.="<input type='hidden' name='form_action' value='mail_send'/>";
	$content.="<input type='hidden' name='mail_id' value='". $mail->id . "'/>";
	$content.="<td><button class='btn btn-default' href='" . $pagelink_edit . '/' . $mail->id .  "'>" . ucfirst(translate("resend")) ."</button></td>";
	$content.="</form>";
	
	$content.="<td><a class='btn btn-default' href='" . $pagelink_edit . '/' . $mail->id .  "'>" . ucfirst(translate("edit")) ."</a></td>";
	$content.="<td><a class='btn btn-default' href='" . $pagelink_delete . '/' . $mail->id .  "'>" . ucfirst(translate("delete")) ."</a></td>";

	$content.=("</tr>");
	
	
}

$content.= "</table>";
$content.="<a class='btn btn-default' href='"  . pagelink('mail_add',$language_id). "'>" . ucfirst(translate('mail_add')) . "</a>";
$content.="<a class='btn btn-default' href='"  . pagelink('mail_templates',$language_id). "'>" . ucfirst(translate('mail_templates')) . "</a>";


?>