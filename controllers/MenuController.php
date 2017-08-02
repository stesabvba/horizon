<?php

	class MenuController extends BaseController {
		
		public function menus(){
			global $language_id;
			global $html_helper;
			global $site_config;

			$urls = [
			'overview_list_url' => pagelink("menus",$language_id,"POST","MenuController@menus_overview_list")
			];

			$html_helper->addJsVar($urls);
			$html_helper->addScript('<script src="'.$site_config['site_url']->value.'/js/admin_menus.js"></script>');

			$url_add = pagelink('menu_add',$language_id);

			$template_vars = [
				'url_add' => $url_add,
			];
			LoadView('admin/menus/menus.php', $template_vars);

			//LoadView('admin/menus/menus.php', $template_vars);
		}


		public function menus_overview_list() {
			global $language_id;
			global $active_route;

			if (isset($_POST['search'])) {
				$search = $_POST['search'];
			} else {
				$search = '';
			}

			if (strlen(trim($search)) > 0) {
				$menus = Menu::where('name', 'LIKE', '%'.$search.'%')->orderBy('name', 'ASC');
			} else {
				$menus = Menu::orderBy('name', 'ASC');
			}

			$menus = $menus->paginate(20);

			$paginator = $this->GetPaginatorLinks($active_route,$menus->elements());

			$url_edit = pagelink('menu_edit',$language_id);
			$url_delete = pagelink('menu_delete',$language_id);

			$template_vars = [
				'url_edit' => $url_edit,
				'url_delete' => $url_delete,
				'menus' => $menus,
				'load_theme' => false,
				'paginator' => $paginator,
				'lbl_items_found' => self::print_nr_items_found($menus->total(), $language_id)
			];

			LoadView('admin/menus/menus_overview_list.php', $template_vars);
		}
		
		public function menu_add_page(){
			
			LoadView('admin/menus/menu_add.php');
		}
		
		
		public function menu_add($request){
			
			global $language_id;
			
			$name = $request['name'];
			
			$m = new Menu();
			$m->name = $name;
			$m->save();
			
			header("Location: " . pagelink('menus',$language_id));
			
		}
		
		public function menu_edit_page(){
			
			LoadView('admin/menus/menu_edit.php');
		}
		
		public function menu_delete_page(){
			global $language_id;
			global $parameters;

			if (isset($parameters[0])) {
				$menu_id = (int)$parameters[0];
			} else {
				$menu_id = 0;
			}

			$template_vars = [
			'actionlink' => 'MenuController@menu_delete',
			'hidden_fields' => [
				'menu_id' => $menu_id,
			]
			];
			LoadView('modals/delete.php', $template_vars);
		}

		public function menu_delete($request) {
			global $language_id;

			if (isset($_REQUEST['menu_id'])) {
				$menu_id = (int)$_REQUEST['menu_id'];
			} else {
				$menu_id = 0;
			}

			$menu = Menu::find($menu_id);
			if (!is_null($menu)) {
				$menu->delete();
			}

			$url_verder = pagelink('menus', $language_id, 'GET', 'MenuController@menus');
			header('Location:'.$url_verder);
			exit;
		}
		
		
		public function menu_item_add_page(){
			
			LoadView('admin/menus/menu_item_add.php');
		}
		
		
		public function menu_item_add($request){
			
			global $language_id;
			
						
			$menu_id = $request["menu_id"];
			
			$parent_id = $request['parent_id'];
			$lang_id = $request['language_id'];
			$page_meta_id = $request['page_meta_id'];
			$alternate_uri = $request['alternate_uri'];
			$menu_text = $request['menu_text'];
			$presentation_order = $request['presentation_order'];
			
			$menu_item = new MenuItem();
			$menu_item->parent_id = $parent_id;
			$menu_item->language_id = $lang_id;
			$menu_item->presentation_order = $presentation_order;
			$menu_item->menu_text = $menu_text;
			
			if($page_meta_id=="")
			{
				$menu_item->alternate_uri = $alternate_uri;
			}else{
				$menu_item->page_meta_id = $page_meta_id;
				$menu_item->alternate_uri = "";
			}
			
			$menu_item->menu_id = $menu_id;
			$menu_item->save();
			
			
			header("Location: " . pagelink('menu_edit',$language_id) . "/" . $menu_id);
			
		}
		
		
		public function menu_item_edit_page(){
			
			LoadView('admin/menus/menu_item_edit.php');
		}
		
		public function menu_item_edit($request)
		{
			global $language_id;
			
			$menu_item_id = $request['menu_item_id'];
			
			$parent_id = $request['parent_id'];
			$lang_id = $request['language_id'];
			$page_meta_id = $request['page_meta_id'];
			$alternate_uri = $request['alternate_uri'];
			$menu_text = $request['menu_text'];
			$presentation_order = $request['presentation_order'];
			
			
			$menu_item = MenuItem::find($menu_item_id);
			
			if($menu_item!=null){
				$menu_item->parent_id = $parent_id;
				$menu_item->language_id = $lang_id;
				$menu_item->presentation_order = $presentation_order;
				$menu_item->menu_text = $menu_text;
				
				if($page_meta_id=="")
				{
					$menu_item->alternate_uri = $alternate_uri;
				}else{
					$menu_item->page_meta_id = $page_meta_id;
					$menu_item->alternate_uri = "";
				}
			
				$menu_item->save();
				
				$menu_id = $menu_item->menu_id;
				
				header("Location: " . pagelink('menu_edit',$language_id) . "/" . $menu_id);
			}else{
				header("Location: " . pagelink('menus',$language_id));
			}
		}
		
		public function menu_item_delete_page(){
			
			LoadView('admin/menus/menu_item_delete.php');
		}
		
		
		public function menu_item_delete($request){
		
			global $language_id;
			
			$menu_item_id = $request['menu_item_id'];
			
			$menu_item = MenuItem::find($menu_item_id);
			$menu_id = $menu_item->menu_id;
			
			$menu_item->delete();
			
			header("Location: " . pagelink('menu_edit',$language_id) . "/" . $menu_id);
		}
	}


?>