<?php

	class Mail extends Illuminate\Database\Eloquent\Model {
		protected $table='mail';
		
		public function user()
		{
			return $this->belongsTo('User');
		}
		
		public function send(){
			require_once '/var/www/vhosts/diaz.be/httpdocs/modules/vendor/swiftmailer/swiftmailer/lib/swift_required.php';
			//require_once '/var/www/vhosts/diaz.be/httpdocs/modules/swiftmailer/lib/swift_required.php';
			$transport = Swift_SmtpTransport::newInstance('127.0.0.1');
			$mailer = Swift_Mailer::newInstance($transport);
			
			$message = Swift_Message::newInstance();

			$message->setSubject($this->subject);
			$message->setFrom(explode(";",$this->from));
			$message->setTo(explode(";",$this->to));

			if (!empty($this->reply_to)) {
				$message->setReplyTo(explode(";",$this->reply_to));
			}

			if($this->cc!=""){
				$message->setCc(explode(";",$this->cc));
			}
			if($this->bcc!=""){
				$message->setBcc(explode(";",$this->bcc));
			}
			
			if($this->attachments!=null){
				$attachments = explode('|',$this->attachments);
				
				foreach($attachments as $attachment){
					$message->attach(Swift_Attachment::fromPath($attachment));
				}
			}

			$message->setBody($this->content,'text/html');
			//add attachments

			$message->addBcc('ict@diaz.be'); //ict@diaz.be altijd in bcc zetten
			
			$result = $mailer->send($message);
			$this->sent_at=date('Y-m-d H:i:s');
			$this->save();
		}

		public function upload_attachment($filename, $tmp_path) {
			return UploadFileInFolder('downloads', $filename, $tmp_path);
		}
	}

?>