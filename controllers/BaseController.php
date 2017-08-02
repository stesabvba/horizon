<?php

use Illuminate\Pagination\Paginator;
class BaseController {
	public $admin_items_per_page;
	public $currentPage;
	public $sort_column, $sort_direction;

	


	public function redirect_home_if_logged_in() {
		global $language_id;

		if (isLoggedIn()) {
			header('Location:'.pagelink('home', $language_id));
			exit;
		}
	}

	public function show_debug_bar() {
		global $globals;
		global $language_id;

		$post_url = actionlink('DevController@update_meta');

		/*$post_url = $globals['current_url'];
		if (substr($post_url, -1) != '?') {
			$post_url .= '?debug=1';
		} else {
			$post_url .= '&debug=1';	
		}*/
		

		if (isset($_POST['save_metas'])) {
			$page_meta = isset($_POST['page_meta'])?$_POST['page_meta']:[];
			if (!empty($page_meta)) {
				foreach($page_meta as $id_page_meta => $arr_fields) {
					$meta = \PageMeta::find($id_page_meta);
					if (!is_null($meta)) {
						foreach($arr_fields as $field_name => $field_val) {
							$meta->{$field_name} = $field_val;
						}	
					}
					$meta->save();
				}
			}
			header('Location:'.$post_url);
			exit;
		}

		$current_meta = $globals['active_page']->pagemetas()->where('language_id', $language_id)->first(); //metas van de huidige taal
		//$metas = ;
		$metas = $globals['active_page']->pagemetas->keyBy('language_id'); //metas in alle talen van deze pagina

		$tpl_vars = [
			'current_meta' => $current_meta,
			'metas' => $metas,
			'globals' => $globals,
			'post_url' => $post_url,
		];

		echo FetchTemplate('views/admin/form_site_metas.php', $tpl_vars);
	}

	public function __construct() {
		global $globals;
		global $language_id;
		global $html_helper;
		global $site_config;
		global $active_page;

		/*if (isLoggedIn()) {
			if ($_SESSION['active_user']['id'] == 6) {
				//6 = david@diaz.be*/
				if (isset($_GET['debug'])) {
					$this->show_debug_bar();
				}
			/*}
		}*/


		if ($active_page->reference != 'my_account') {
			if (isset($_SESSION['my_account_page'])) {				
				unset($_SESSION['my_account_page']);
			}
		}

		if ($active_page->reference != 'register_user') {
			if (isset($_SESSION['register_user'])) {
				unset($_SESSION['register_user']);
			}
		}

		if (!in_array($active_page->reference, ['vacancies', 'vacancy_apply'])) {
			if (isset($_SESSION['vacancy_apply_page'])) {
				unset($_SESSION['vacancy_apply_page']);
			}	
		}

		if ($active_page->reference != 'contact') {
			if (isset($_SESSION['contact_page'])) {
				unset($_SESSION['contact_page']);
			}
		}

		if ($active_page->reference != 'request_link_user_customer') {
			if (isset($_SESSION['request_link_user_customer_page'])) {
				unset($_SESSION['request_link_user_customer_page']);
			}
		}

		

		
		$this->get_page();
		$this->get_sortcolumn();
		$this->get_sortdirection();

		$this->admin_items_per_page = 15;


	}

	protected function get_page()
	{
		if(isset($_GET["page"]))
		{
			$currentPage=$_GET['page'];

			$this->currentPage = $currentPage;

			 Paginator::currentPageResolver(function () use ($currentPage) {
       			 return $currentPage;
   			 });


		}else{
			$this->currentPage = 1;
		}
	}

	protected function get_sortcolumn()
	{
		if(isset($_GET["sort_column"]))
		{
			$this->sort_column=$_GET["sort_column"];


		}
	}

	protected function get_sortdirection()
	{
		if(isset($_GET["sort_direction"]))
		{
			$this->sort_direction=$_GET["sort_direction"];
		}
	}

	public function print_nr_items_found($nr_items, $language_id) {
		$str = translate('nr_items_found', $language_id);		
		$str = str_replace('%nr_items%', $nr_items, $str);
		echo $str;
	}

	public function GetPaginatorLinks($active_route, $elements)
		{
			global $site_config;
			//var_dump($elements);
			//echo 'currentPage='.$this->currentPage;
			$result="";
			if(!array_key_exists(0,$elements[0])){
				
			
			$lastpage=0;
			$result.="<ul class='pagination'>";
			if($this->currentPage>1)
			{
			$result.="<li><a class='paginationlink' href='" . $site_config['site_url']->value . $active_route->uri . '?page=' . ($this->currentPage-1) . "'>&lt;&lt;</span></a></li>";
			}
			while(list($key,$pages) = each($elements))
			{
				
				if(is_array($pages))
				{
					while(list($pagenumber,$pagelink)=each($pages))
						{
							if($pagenumber==$this->currentPage)
							{
								$result.="<li class='active'><a class='paginationlink' href='" . $site_config['site_url']->value . $active_route->uri . str_replace('/','',$pagelink) . "'>" . $pagenumber . "</a></li>";

							}else{
								$result.="<li><a class='paginationlink' href='" . $site_config['site_url']->value . $active_route->uri . str_replace('/','',$pagelink) . "'>" . $pagenumber . "</a></li>";
							}
							
							$lastpage=$pagenumber;
						}

				}else{
					$result.="<li><a class='paginationlink' href='#'>$pages</a></li>";
				}

				
			}


			if($this->currentPage+1<=$lastpage)
			{
			$result.="<li><a class='paginationlink' href='" . $site_config['site_url']->value . $active_route->uri . '?page=' . ($this->currentPage+1) . "'>&gt;&gt;</a></li>";
			}
			$result.="</ul>";

			}
		

			return $result;
		}

	protected function get_current_page($sessionkey = 'page') {
		//= pagination variable

		if (isset($_GET[$sessionkey])) {
			$page = (int)$_GET[$sessionkey];
		} elseif (isset($_SESSION['admin_vars'][$sessionkey])) {
			$page = (int)$_SESSION['admin_vars'][$sessionkey];
		} else {
			$page = 0;
		}

		$_SESSION['admin_vars'][$sessionkey] = $page;

		return $page;
	}

	public function get_theme_basepath() {
		global $active_page;
		global $site_config;

		$theme_basepath = false;

		if (!is_null($active_page)) {
			$theme_basepath = $site_config['site_url']->value . $active_page->theme->location; 	
		}
		
		return $theme_basepath;
	}

	/*public function get_base_url() {
		global $site_config;
		
		//http://10.0.0.13/horizon/
		$str = $site_config['site_url']->value;
		return $str;		
	}*/
}