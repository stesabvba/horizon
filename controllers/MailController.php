<?php
	require('BaseController.php');

	class MailController extends \App\BaseController {
		
		public function mails()
		{
			global $html_helper;
			global $site_config;
			global $language_id;

			$urls = [
			'url_overview_ajax' => pagelink("mails",$language_id,"POST","MailController@mails_overview_ajax")
			];
			
			$html_helper->addJsVar($urls);
			$html_helper->addScript('<script src="'.$site_config['site_url']->value.'/js/admin_mails.js?'.time().'"></script>');

			$template_vars = [
			];

			$b_new = isset($_REQUEST['nieuw'])?true:false;
			LoadView('admin/mails/mails.php', $template_vars);	
		}

		public function mails_overview_ajax() {
			global $language_id;
			global $active_route;

			$search = isset($_POST['search'])?$_POST['search']:'';

			if (!empty($search)) {
				$mails = Mail::where('subject', 'LIKE', '%'.$search.'%')
				->orWhere('from', 'LIKE', '%'.$search.'%')
				->orWhere('to', 'LIKE', '%'.$search.'%')
				->orderBy('sent_at', 'DESC');
			} else {
				$mails = Mail::orderBy('sent_at', 'DESC');
			}
			$mails = $mails->paginate(20);

			$paginator = $this->GetPaginatorLinks($active_route,$mails->elements());

			$pagelink_edit = pagelink('mail_edit',$language_id);
			$pagelink_delete = pagelink('mail_delete',$language_id);

			$template_vars = [
			'mails' => $mails,
			'pagelink_edit' => $pagelink_edit,
			'pagelink_delete' => $pagelink_delete,
			'load_theme' => false,
			'paginator' => $paginator,
			'lbl_items_found' => self::print_nr_items_found($mails->total(), $language_id)
			];

			LoadView('admin/mails/mails_overview_ajax.php', $template_vars);
		}
		
		public function mail_add_page()
		{
			LoadView('admin/mails/mail_add.php');
		}
		
		public function mail_add($request)
		{
			global $language_id;
			
			$to = $request["to"];
			$cc = $request["cc"];
			$bcc = $request["bcc"];
			$subject = $request["subject"];
			$language_id = $request["language_id"];
			$content = $request["content"];
			
			$mail = new Mail();
			$mail->from = $active_user->email;
			$mail->user_id=$active_user->id;
			$mail->to = $to;
			$mail->cc = $cc;
			$mail->bcc = $bcc;
			$mail->language_id=$language_id;
			$mail->content = $content;
			$mail->subject = $subject;
			$mail->save();
			
			header("Location: " . pagelink('mails',$language_id));
		}
		
		public function mail_edit_page()
		{
			LoadView('admin/mails/mail_edit.php');
		}
		public function mail_edit($request)
		{
			global $language_id;
			
			$mail_id=$request["mail_id"];
			$to = $request["to"];
			$cc = $request["cc"];
			$bcc = $request["bcc"];
			$subject = $request["subject"];
			$language_id = $request["language_id"];
			$content = $request["content"];
			
			$mail = Mail::find($mail_id);
			
			$mail->to = $to;
			$mail->cc = $cc;
			$mail->bcc = $bcc;
			$mail->language_id=$language_id;
			$mail->content = $content;
			$mail->subject = $subject;
			$mail->save();
			
			header("Location: " . pagelink('mails',$language_id));
			
		}
		
		public function mail_delete_page()
		{
			LoadView('admin/mails/mail_delete.php');
		}
		
		public function mail_delete($request)
		{
			$mail_id = $request["mail_id"];
			
			$mail = Mail::find($mail_id);
			
			$mail->delete();
			
			header("Location: " . pagelink('mails',$language_id));
			
		}
		
		public function mail_send($request){
			global $language_id;
			$mail_id=$request["mail_id"];
			
			$mail = Mail::find($mail_id);
			$mail->send();
			
			header("Location: " . pagelink('mails',$language_id));
		}
		
		
		public function mail_template_edit_page(){
			LoadView('admin/mails/mail_template_edit.php');
		}			
		
		public function mail_template_edit($request){
			
			global $language_id;
			
			$mail_template_html = $request['template_file_html'];
			$mail_template_file = $request['template_file'];
			
			//die($mail_template_html);
			
			file_put_contents(__DIR__ . "/../tinymce_templates/".$mail_template_file.".html" , $mail_template_html);
			
			header("Location: " . pagelink('mail_templates',$language_id));
			
		}
		
		public function mail_template_add_page(){
			LoadView('admin/mails/mail_template_add.php');
		}
		
		public function mail_template_add($request){
			global $language_id;
			
			$mail_template_html = $request['template_file_html'];
			$mail_template_title = $request['template_file_name'];
			
			$mail_template_file_name = str_replace(" ","_",$mail_template_title);
			//die($mail_template_html);
			
			file_put_contents(__DIR__ . "/../tinymce_templates/".$mail_template_file_name.".html" , $mail_template_html);
			
			header("Location: " . pagelink('mail_templates',$language_id));
			
		}
		
		public function mail_template_delete_page(){
			LoadView('admin/mails/mail_template_delete.php');
			
		}
		
		public function mail_template_delete($request){
			global $language_id;
			
			$mail_template_title = $request['template_file_name'];
			
			$mail_template_file_name = str_replace(" ","_",$mail_template_title);

			
			unlink(__DIR__ . "/../tinymce_templates/".$mail_template_file_name.".html");
			
			header("Location: " . pagelink('mail_templates',$language_id));
			
		}
			
	
	}

?>