<?php

	if(isset($parameters[0])){
		$mailinglist_id=$parameters[0];
	}else{
		$mailinglist_id=0;
	}
	
	$mailinglist = Mailinglist::find($mailinglist_id);
	
	if($mailinglist==null){
		header("Location:" . pagelink("mailinglist_members",$language_id));
	}
	
$content.="<form role='form' method='post'>";
	$content.="<div class='modal-header'>";
		$content.="<h3>" . $active_pagemeta->title . "</h3>";
	$content.="</div>";

	$content.="<div class='modal-body'>";

		$content.="<input type='hidden' name='form_action' value='mailinglist_member_add'>";
		$content.="<input type='hidden' name='mailinglist_id' value='". $mailinglist->id . "'>";
	
		$members = MailinglistMember::select('user_id')->where('mailinglist_id',$mailinglist->id)->get()->keyBy('user_id')->toArray();
	
		
		$users = User::where('active',1)->whereNotIn('id',array_keys($members))->get();
		
		foreach($users as $user){
			
			$content.="<div class='form-group'>";
			$content.="<div class='checkbox'>";
				$content.="<label><input name='user[" . $user->id ."]' type='checkbox'>" . $user->firstname . " " . $user->lastname . " (" . $user->defaultlanguage->shortname . ")</label>";
			$content.="</div>";
			$content.="</div>";
		}
	
		
				
	$content.="</div>";

	$content.="<div class='modal-footer'>";
		$content.="<button type='submit' class='btn btn-primary'>". ucfirst(translate("add")) ."</button>";
		$content.="<button type='button' class='btn btn-secondary' data-dismiss='modal'>" . ucfirst(translate("close")) . "</button>";
	$content.="</div>";
$content.="</form>";
       
?>