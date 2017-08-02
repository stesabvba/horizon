<?php
	require('BaseController.php');

	class MailinglistController extends \App\BaseController {
	{
		public function mailinglist_add_page(){
			LoadView('admin/mailinglists/mailinglist_add.php');
		}
		public function mailinglist_add($request){
			global $language_id;
		
			$name=$request["name"];
		
			$enduser=0;
			
			if(isset($request['enduser'])){
				$enduser=1;
			}
			
			$m = new Mailinglist();
			$m->name=$name;
			$m->enduser=$enduser;
			$m->save();
			
			header("Location: " . pagelink('mailinglists',$language_id));
			
		}
		
		public function mailinglist_edit_page(){
			LoadView('admin/mailinglists/mailinglist_edit.php');
		}
		
		public function mailinglist_edit(){
			global $language_id;
		
			
			$mailinglist_id=$request["mailinglist_id"];
			
			
			$name=$request["name"];
		
			$enduser=0;
			
			if(isset($request['enduser'])){
				$enduser=1;
			}
			
			$m = Mailinglist::find($mailinglist_id);
			$m->name=$name;
			$m->enduser=$enduser;
			$m->save();
			
			header("Location: " . pagelink('mailinglists',$language_id));
			
		}
		
		public function mailinglist_delete_page(){
			LoadView('admin/mailinglists/mailinglist_delete.php');
		}
			
		public function mailinglist_delete($request){
			
			global $language_id;
			
			$mailinglist_id=$request["mailinglist_id"];
			
			$m = Mailinglist::find($mailinglist_id);
			$m->delete();
			
			header("Location: " . pagelink('mailinglists',$language_id));
			
		}
		
		public function mailinglist_member_add(){
			LoadView('admin/mailinglists/mailinglist_member_add.php');
		}
		
		public function mailinglist_member($request){
			global $language_id;
			
			$mailinglist_id=$request["mailinglist_id"];
			
			$users = $request["user"];
			
			while(list($key,$value)=each($users)){
				$user = User::find($key);
				
				if($user!=null){
					$mm = new Mailinglistmember();
					$mm->user_id=$user->id;
					$mm->language_id=$user->default_language_id;
					$mm->mailinglist_id=$mailinglist_id;
					$mm->save();
				}
			}
			
			header("Location: " . pagelink('mailinglist_members',$language_id) . "/" . $mailinglist_id);
		}
		
		public function mailinglist_member_edit_page(){
			LoadView('admin/mailinglists/mailinglist_member_edit.php');
		}
		
		public function mailinglist_member_edit($request){
			
			global $language_id;
			
			$mailinglist_member_id=$request["mailinglist_member_id"];
			$lang_id=$request["language_id"];
			
			$mm = Mailinglistmember::find($mailinglist_member_id);
			
			$mm->language_id=$lang_id;
			$mailinglist_id = $mm->mailinglist_id;
			
			$mm->save();
			
			header("Location: " . pagelink('mailinglist_members',$language_id) . "/" . $mailinglist_id);
		}
		
		public function mailinglist_member_delete_page(){
			LoadView('admin/mailinglists/mailinglist_member_delete.php');
		}
			
		public function mailinglist_member_delete($request){
			
			$mailinglist_member_id=$request["mailinglist_member_id"];
			
			$mm = Mailinglistmember::find($mailinglist_member_id);
			
			$mailinglist_id = $mm->mailinglist_id;
			
			$mm->delete();
			
			header("Location: " . pagelink('mailinglist_members',$language_id) . "/" . $mailinglist_id);
		}
	
		public function mailinglist_message_add_page(){
			LoadView('admin/mailinglists/mailinglist_message_add_page.php');
		}
		
		public function mailinglist_message_add($request){
			global $language_id;
			
			$mailinglist_id=$request["mailinglist_id"];
			$name=$request["name"];
			$contents = $request["content"];
			$subjects = $request["subject"];
			
			$mm = new MailinglistMessage();
			$mm->mailinglist_id=$mailinglist_id;
			$mm->name=$name;
			$mm->save();
			
			while(list($key,$value)=each($contents)){
				$mmd = new MailinglistMessageDetail();
				$mmd->mailinglist_message_id=$mm->id;
				$mmd->message=$value;
				$mmd->subject=$subjects[$key];
				$mmd->language_id=$key;
				$mmd->save();
			}
			
			header("Location: " . pagelink('mailinglist_messages',$language_id) . "/" . $mailinglist_id);
	
		}
			
		public function mailinglist_message_edit_page(){
			LoadView('admin/mailinglists/mailinglist_message_edit.php');
		}
		
		public function mailinglist_message_edit($request){
			global $language_id;
			
			$mailinglist_message_id=$request["mailinglist_message_id"];
			
			
			$name=$request["name"];
			$contents = $request["content"];
			$subjects = $request["subject"];
			
			$mm = MailinglistMessage::find($mailinglist_message_id);
			$mm->name=$name;
			$mm->save();
			$mailinglist_id = $mm->mailinglist_id;
			
			while(list($key,$value)=each($contents)){
				
				$mmd = $mm->details->where("language_id",$key)->first();
				if($mmd==null){ //indien nog niet bestaat
					$mmd = new MailinglistMessageDetail();
					$mmd->mailinglist_message_id=$mm->id;
					$mmd->language_id=$key;
				}
				
				$mmd->message=$value;
				$mmd->subject=$subjects[$key];
				$mmd->save();
			}
			
			header("Location: " . pagelink('mailinglist_messages',$language_id) . "/" . $mailinglist_id);
	
		}
			
		public function mailinglist_message_delete_page(){
			LoadView('admin/mailinglists/mailinglist_message_delete_page.php');
		}
		
		public function mailinglist_message_delete($request){
			$mailinglist_message_id=$request["mailinglist_message_id"];
			$mm = MailinglistMessage::find($mailinglist_message_id);
		
			$mailinglist_id = $mm->mailinglist_id;
			
			$mm->delete();
			
			header("Location: " . pagelink('mailinglist_messages',$language_id) . "/" . $mailinglist_id);
			
		}
		
		
		
		
	}

?>