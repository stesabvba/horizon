<?php
require('BaseController.php');

use Illuminate\Database\Capsule\Manager as DB;

	class UserController extends \App\BaseController
	{
		public function users(){
			global $language_id,$html_helper,$site_config;
			global $active_user;

			
		
			$pagelink_useradd = pagelink('user_add',$language_id);

			$pagelink_user_customerlink = pagelink('user_customer_link', $language_id);

			$urls = [
				'userlist_url' => pagelink("users",$language_id,"POST","UserController@user_list")
				
			];
			$html_helper->addJsVar($urls);


			$html_helper->addScript('<script src="'.$site_config['site_url']->value.'/js/admin_users.js"></script>');

			$template_vars = [

				'pagelink_useradd' => $pagelink_useradd,		
				'pagelink_user_customerlink' => $pagelink_user_customerlink,		

			];


			//$tpl = ($active_user->email = 'david@diaz.be')?'users2.php':'users.php';

			//LoadView('admin/users/'.$tpl, $template_vars);
			LoadView('admin/users/users.php', $template_vars);
		}


		public function user_list(){

			global $language_id, $active_route;

			$user_linktype = isset($_POST['user_linktype'])?$_POST['user_linktype']:1;

			$b_search = isset($_POST['search']) && !empty($_POST['search'])?true:false;

			if($b_search)
			{
				$users = User::where(function($query) {
					$query->where('firstname','LIKE', '%' . $_POST['search'] . '%')
					->orWhere('lastname','LIKE', '%' . $_POST['search'] . '%')
					->orWhere('email','LIKE', '%' . $_POST['search'] . '%')
					->orWhere('company','LIKE', '%' . $_POST['search'] . '%')
					->orWhere('username','LIKE', '%' . $_POST['search'] . '%');	
				});
			}else{
				//$users = User::paginate(20);
			}

			switch($user_linktype) {
				case 2:
					//users die gelinkt zijn aan een customer
					if ($b_search) {
						$users = $users->whereHas('customers');
					} else {
						$users = User::whereHas('customers');
					}
					//echo $users->toSql();					
					$users = $users->paginate(20);		
				break;

				case 3:
					//users die nog NIET gelinkt zijn aan een customer
					if ($b_search) {
						$users = $users->has('customers', '=', 0);
					} else {
						$users = User::has('customers', '=', 0);
					}
					//echo $users->toSql();					
					$users = $users->paginate(20);		
				break;

				case 4:
					//users die gelinkt zijn aan een customer die dissabled is
					if ($b_search) {
						$users = $users->whereHas('customers',function($query){ 
							$query->where('is_archived',1);
							$query->orwhere('order_entry_not_allowed',1);
						});
					} 
					else 
					{
						$users = User::whereHas('customers',function($query){ 
							$query->where('is_archived',1);
							$query->orwhere('order_entry_not_allowed',1);
						});
					}
					//echo $users->toSql();					
					$users = $users->paginate(20);		
				break;

				default:
					//all users (case 1)
					if($b_search) {
						$users = $users->paginate(20);
					} else {
						$users = User::paginate(20);
					}
				break;
			}
			
			/**/

			
			$pagelink_edit = pagelink('user_edit',$language_id);
			$pagelink_delete = pagelink('user_delete',$language_id);

			$paginator = $this->GetPaginatorLinks($active_route,$users->elements());

			$template_vars = [
				'users' => $users,
				'paginator' => $paginator,
				'load_theme' => false,
				'pagelink_edit' => $pagelink_edit,				
				'pagelink_delete' => $pagelink_delete,	
			];

			LoadView('admin/users/user_list.php',$template_vars);
		}
		
		public function user_add_page(){
			LoadView('admin/users/user_add.php');
		}
		
		public function move_userright($request){
		
			$from=$request["from"];
			$to=$request["to"];
			
			$userright = UserRight::find($from);
			
			$userright->parent_id=$to;
			$userright->save();
		}
		
		public function login($request){
			$username = $request["username"];
			$password = $request["password"];
			$target_url = $request["target_url"];
			
			$user = User::where('username',$username)->where('password',$password)->where('active',1)->first();
		
			if($user!=null){
				$_SESSION['active_user']=$user;
				
				$user->lastloggedin_at = date('Y-m-d H:i:s');
				$user->save();
				
				header("Location: $target_url");
			}
		
		}
		
		public function user_add($request){
			global $language_id;
			global $active_user;
			
			$firstname = $request["firstname"];
			$lastname = $request["lastname"];
			$username = $request["username"];
			$email = $request["email"];
			$password = md5($request["password"]);
			$communication_language_id = $request['communication_language_id'];
			
			$active=0;
			
			if(isset($request['active'])){
				$active=1;
			}
			
			$user = new User();
			
			$user->firstname=$firstname;
			$user->lastname=$lastname;
			$user->email=$email;
			$user->username=$username;
			$user->password=$password;
			if ($active_user->has_profile('admin')) {				
				//als admin kan je profiel kiezen, anders wordt het profiel standaard op admin ingesteld
				$profile_id = $request["profile_id"];				
				$user->profile_id=$profile_id;
			} else {
				$user->profile_id = Profile::where('name', 'dealer')->first()->id;
			}

			$user->active=$active;
			$user->communication_language_id=$communication_language_id;
			
			$user->save();
			
			header("Location: " . pagelink('users',$language_id));
		}

		public function user_edit_customerdelete_page() {
			global $language_id;
			global $parameters;

			$user_id = isset($parameters[0])?$parameters[0]:0;
			$customer_id = isset($parameters[1])?$parameters[1]:0;

			$template_vars = [
				'actionlink' => 'UserController@user_edit_customerdelete',
				//'cancellink' => pagelink('user_customer',$language_id).'/'.$user_id, 
				'hidden_fields' => [
					'user_id' => $user_id,
					'customer_id' => $customer_id,
				]
			];
			LoadView('modals/delete.php', $template_vars);
		}

		public function user_edit_customerdelete($request) {
			global $language_id;

			$user_id = isset($request['user_id'])?$request['user_id']:0;
			$customer_id = isset($request['customer_id'])?$request['customer_id']:0;

			$sql = 'DELETE FROM user_customer WHERE user_id = :user_id AND customer_id = :customer_id';
			DB::delete($sql, ['customer_id' => $customer_id, 'user_id' => $user_id]);
			header('Location:'.pagelink('user_customer',$language_id).'/'.$user_id);
			exit;
		}

		public function user_edit_customers_page() {
			global $language_id;
			global $parameters;
			global $active_pagemeta;

			$user_id = isset($parameters[0])?$parameters[0]:0;
			$user = User::find($user_id);


			if (is_null($user)) {
				header('Location:'.pagelink('users',$language_id));
				exit;
			}

			$tabs = [];
			$tabs[] = [
				'label' => ucfirst(translate('user')),
				'url' => pagelink('user_edit',$language_id).'/'.$user->id,
				'class' => '',				
			];
			
			$tabs[] = [
				'label' => ucfirst(translate('customers')),
				'url' => pagelink('user_customer',$language_id).'/'.$user->id,
				'class' => 'active',
			];


			$customer_add_link = pagelink('user_customer_add',$language_id).'/'.$user->id;
			$customer_delete_link = pagelink('user_customer_delete',$language_id);
			
			$sql  ='SELECT customer.id AS customer_id, department.*, department_type.name AS department_type_name
			FROM customer, department, user_customer, department_type
			WHERE user_customer.user_id = '.(int)$user->id;
			$sql .= ' AND user_customer.customer_id = customer.id';
			$sql .= ' AND customer.department_id = department.id
			AND department.department_type = department_type.department_type
			ORDER BY department.name ASC';
			$customers = DB::select($sql);

			$template_vars = [
				'tabs' => $tabs,
				'user' => $user,
				'customer_add_link' => $customer_add_link,
				'customer_delete_link' => $customer_delete_link,
				'customers' => $customers,
			];
			LoadView('admin/users/customers.php', $template_vars);
		}
		
		public function user_edit_page(){
			global $language_id;
			global $parameters;
			global $active_pagemeta;
			global $active_user;

			$user_id = isset($parameters[0])?$parameters[0]:0;
			$user = User::find($user_id);

			if (is_null($user)) {
				header('Location:'.pagelink('users',$language_id));
				exit;
			}
			
			$tabs = [];
			$tabs[] = [
				'label' => ucfirst(translate('user')),
				'url' => pagelink('user_edit',$language_id).'/'.$user->id,
				'class' => 'active',
			];
			
			$tabs[] = [
				'label' => ucfirst(translate('customers')),
				'url' => pagelink('user_customer',$language_id).'/'.$user->id,
				'class' => '',
			];

			$template_vars = [
				'tabs' => $tabs,
				'user_id' => $user_id,
				'user' => $user,
			];

			LoadView('admin/users/user_edit.php', $template_vars);
		}

		public function user_edit_customeradd_page() {
			global $parameters;
			global $language_id;
			global $active_pagemeta;

			$user_id = isset($parameters[0])?$parameters[0]:0;
			$user_id = (int)$user_id;

			$user = User::find($user_id);
			if (is_null($user)) {
				header('Location:'.pagelink('users',$language_id));
				exit;
			}

			/*$sql  ='SELECT customer.id AS customer_id, department.*, department_type.name AS department_type_name
			FROM customer, department, department_type
			WHERE 1
			AND customer.department_id = department.id
			AND customer.id NOT IN (SELECT DISTINCT(customer_id) FROM user_customer WHERE user_id = :user_id)
			AND department.department_type = department_type.department_type
			ORDER BY department.name ASC';
			$customers = DB::select($sql, ['user_id' => $user->id]);*/

			$template_vars = [
				'user' => $user,
				
				'actionlink' => 'UserController@user_edit_customeradd',				
			];
			LoadView('admin/users/customer_add_page.php', $template_vars);
		}

		public function user_edit_customersearch()
		{
			$search = $_GET['q'];

			if($search!=null)
			{
				$customers = Customer::with('department.departmenttype')->whereHas('department.company',function($query) use($search){ $query->where('name','LIKE',"%" . $search . "%"); })->orWhere('number',$search)->limit(50)->get();

			}else{
				$customers = Customer::first(100);
			}
			$key=0;
			$list = array();
			foreach ($customers as $customer) {
	            $list[$key]['id'] = $customer->id;
	            $department_type = $customer->department->departmenttype->name;
	            $list[$key]['text'] = $customer->number . " - " .$customer->department->company->name . " ($department_type) - " . $customer->department->city; 

	            $key++;
	        }
	        $result=array();
	        $result['items']=$list;

        	echo(json_encode($result));
		}

		public function user_edit_customeradd($request) {
			global $language_id;

			$customer_ids = $request['customer_id'];
			$user_id = isset($request['user_id'])?(int)$request['user_id']:0;
			$user = User::find($user_id);
			$user->customers()->detach();

			if (!empty($user_id)) {

				foreach($customer_ids as $customer_id)
				{
					
					$user->customers()->attach($customer_id);
				}
				
			}
			
			header('Location:'.pagelink('user_customer',$language_id).'/'.$user_id);
			exit;
		}
		
		public function user_edit($request){
			global $language_id;
			global $active_user;
			
			$user_id = $request["user_id"];
			$firstname = $request["firstname"];
			$lastname = $request["lastname"];
			
			$email = $request["email"];
			if($request["password"]!="")
			{
				$password = md5($request["password"]);
			}else{
				$password = "";
			}

			$communication_language_id = $request['communication_language_id'];
			
			$active=0;
			
			if(isset($request['active'])){
				$active=1;
			}
			
			$user = User::find($user_id);
			
			$user->firstname=$firstname;
			$user->lastname=$lastname;
			$user->email=$email;
			$user->username=$email;
			if($password!=""){
				$user->password=$password;
			}
		
			if ($active_user->has_profile('admin')) {
				$profile_id = $request["profile_id"];		
				$user->profile_id=$profile_id;
			}
			
			$user->active=$active;
			$user->communication_language_id=$communication_language_id;
			
			$user->save();

			header("Location: " . pagelink('users',$language_id));
		}
		
		public function user_delete_page(){
			LoadView('admin/users/user_delete.php');
		}
		
		public function user_delete($request){
			global $language_id;
			
			$user_id = $request["user_id"];
			$user = User::find($user_id);
			if (!is_null($user)) {
				$user->delete();				
			}
			
			header("Location: " . pagelink('users',$language_id));			
		}

		public function customer_linklist() {
			global $language_id;
			global $active_pagemeta;
			global $html_helper;
			global $active_route;
			global $site_config;
			global $globals;

			$user_firma = collect(DB::select("SELECT * FROM user WHERE company != ''"))->keyBy('id');

			$sql = "SELECT customer.id, department.name, department_type.name AS department_type_label
			FROM customer, department, department_type
			WHERE 1
			AND customer.department_id = department.id
			AND department.department_type = department_type.department_type
			ORDER BY department.name ASC";
			$res_departments = DB::select($sql);
			$departments = collect($res_departments)->keyBy('id');

			$users = User::orderBy('id', 'ASC')->paginate($this->admin_items_per_page, ['*'], 'page', $this->get_current_page());

			if (!empty($users)) {
				foreach($users as $key_user => $user) {
					$firma = '';
					$customer_voorstel_id = 0;

					if (!empty($user_firma[$user->id])) {
						$firma = $user_firma[$user->id]->company;
						
						$sql = "SELECT customer.id
						FROM customer, department, department_type
						WHERE department.name LIKE '%".addslashes($firma)."%'
						AND customer.department_id = department.id
						AND department.department_type = department_type.department_type LIMIT 1";
						$ret = DB::select($sql);
						if (!empty($ret)) {
							$customer_voorstel_id = $ret[0]->id;
						}
					}
					$user->customer_voorstel_id = $customer_voorstel_id;
					$user->firma_voorstel = $firma;

					$users[$key_user] = $user;
				}
			}		

			$postlink = pagelink('user_customer_link_add', $language_id, 'POST');			
			$deletelink = pagelink('user_customer_link_delete', $language_id);

			$template_vars = [
				'users' => $users,				
				'departments' => $departments,
				'user_firma' => $user_firma,
				'postlink' => $postlink,
				'deletelink' => $deletelink,
				'pager' => $html_helper->pager($globals['current_url'], $users->total(), $this->admin_items_per_page, $users->currentPage()),
			];
			LoadView('admin/users/customer_linklist.php', $template_vars);			
		}

		public function customerlink_linklist_add($request) {
			//add customer to user
			global $language_id;
			global $parameters;

			$user_id = isset($request['user_id'])?$request['user_id']:0;
			$customer_id = isset($request['customer_id'])?$request['customer_id']:0;

			if (!empty($customer_id) && !empty($user_id)) {
				$user = User::find($user_id);
				$user->customers()->attach($customer_id);
			}
			
			header('Location:'.pagelink('user_customer_link',$language_id).'#user'.$user_id);
			exit;
		}

		public function customerlink_linklist_delete() {
			global $parameters;
			global $language_id;

			$user_id = isset($parameters[0])?$parameters[0]:0;
			$customer_id = isset($parameters[1])?$parameters[1]:0;

			$user = User::find($user_id);
			if (!is_null($user)) {
				$user->customers()->detach($customer_id);
			}
			header('Location:'.pagelink('user_customer_link',$language_id).'#user'.$user_id);
			exit;
		}
	}

?>