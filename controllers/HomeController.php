<?php

	class HomeController extends BaseController {

		public function homepage(){
			global $active_page;			

			LoadView('home/home.php');
		}


		public function manage()
		{
			LoadView('admin/manage.php');
		}

	
		
		public function page_not_found()
		{
			LoadView('errors/page_not_found.php');
		}
		
		public function user_not_authorized()
		{
			LoadView('errors/user_not_authorized.php');
		}

	
		public function login_page(){
			global $language_id, $logged_in;
			global $globals;


			$template_data = [
				'pagelink_register_user' => pagelink('register_user', $language_id),
				'pagelink_forgot_your_password' => pagelink('forgot_password', $language_id),
			];

			LoadView('home/login.php', $template_data);
		}
		
		public function login($request){
			global $language_id;
			global $msg_helper;

			
			$username = $request['username'];
			$password = $request['password'];
			
			$user = User::where('username',$username)->where('password',md5($password))->where('active',1)->first();


			if (!is_null($user)) {
				$_SESSION['active_user']=$user;

				
				header('Location: ' . pagelink('customer_zone',$language_id));

			} else {
				$msg_helper->set('messages', 0, ucfirst(translate('login_no_user_found')));	

				$pagelink = pagelink('login', $language_id);

				header('Location:'.$pagelink);

			}
		}
		
		public function logout()
		{
			global $language_id;
			
			if (isset($_SESSION['active_user'])) {
				unset($_SESSION['active_user']);
				session_destroy();	
			}
		
			header('Location: ' . pagelink('home',$language_id));
			exit;
		}

		
	}
?>