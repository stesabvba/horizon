<?php
use Illuminate\Database\Capsule\Manager as DB;


	class PageController extends BaseController {
		public function defaultpage(){
			LoadView('empty_page.php');
		}
		
		public function pages(){
			global $site_config, $html_helper, $language_id;

			$urls = [
						'pagelist_url' => pagelink("pages",$language_id,"POST","PageController@page_list")
						
					];

			$html_helper->addJsVar($urls);


			$html_helper->addScript('<script src="'.$site_config['site_url']->value.'/js/admin_pages.js"></script>');

			LoadView('admin/pages/pages.php');
		}

		public function page_list(){

			global $language_id, $active_route;

			$sortfield = $_POST['sortfield'];
			$sortdirection = $_POST['sortdirection'];

			if(isset($_POST['search']))
			{
				$pages = Page::where('reference','LIKE', '%' . $_POST['search'] . '%')->orderBy($sortfield,$sortdirection)->paginate(20);
			}else{
				$pages = Page::orderBy($sortfield,$sortdirection)->paginate(20);
			}

			

			$paginator = $this->GetPaginatorLinks($active_route,$pages->elements());

			$template_vars = [
				'pages' => $pages,
				'paginator' => $paginator,
				'load_theme' => false
			];

			LoadView('admin/pages/page_list.php',$template_vars);
		}
		
		public function page_add_page(){
			LoadView('admin/pages/page_add.php');
		}
		
		public function page_urls($request){
			
			$urls = array();
			$parent_id = $request['parent_id'];
			
			$page = Page::find($parent_id);
			
			$pagemetas = $page->pagemetas;
			
			foreach($pagemetas as $pagemeta){
				
				$urls[$pagemeta->language_id]=$pagemeta->defaulturi();
						
			}
			
			echo(json_encode($urls));
		}
		
		public function page_add($request){

			global $language_id;
			
			$reference = $request['reference'];
			$parent_id = $request['parent_id'];
			$theme_id = $request['theme_id'];
			$custom_css = $request['custom_css'];
			$custom_js = $request['custom_js'];
			$presentation_order = $request['presentation_order'];
			$urls = $request['url'];
			
			$active=0;
			$show_in_menu=0;
			$login_required=0;
			
			if(isset($request['active'])){
				$active=1;
			}
			if(isset($request['show_in_menu'])){
				$show_in_menu=1;
			}
			if(isset($request['login_required'])){
				$login_required=1;
			}
			
			$page = new Page();
			$page->reference = $reference;
			$page->parent_id = $parent_id;
			$page->theme_id = $theme_id;
			
			$page->active = $active;
			
			$page->presentation_order = $presentation_order;
			
			$page->save();
			$parentpage = Page::find($page->parent_id);
			
			$languages = Language::all();
			
	
			while(list($lang_id,$url)=each($urls)){
				
				if($url!=''){
					$language = Language::find($lang_id);
					
					$pagemeta = new PageMeta();
					$pagemeta->name=$page->reference . " " . $language->shortname;
										
					$pagemeta->language_id=$language->id;
					$pagemeta->title=$page->reference . " " . $language->shortname;
					
					$pagemeta->description=$page->reference . " " . $language->shortname;
					$pagemeta->keywords=$page->reference . " " . $language->shortname;
					$pagemeta->page_id=$page->id;
					$pagemeta->save();
					
									
					$route = new Route();
					$route->page_meta_id = $pagemeta->id;
					$route->method='GET';
					$route->uri = $url;
					$route->controller_function = 'PageController@defaultpage';
					
					$route->save();
				}
			}
			
			$userright = new UserRight();
			$userright->name='view_' . $page->reference . '_page';
			$userright->parent_id=0;
			$userright->page_id=$page->id;
			$userright->save();
			
		
			header("Location: " . pagelink('page_edit',$language_id) . "/" . $page->id);
		}
		
		
		public function page_edit_page(){
			LoadView('admin/pages/page_edit.php');
		}
		
		public function page_edit($request){
			global $language_id;
			
			$page_id = $request["page_id"];
			$reference = $request['reference'];
			$parent_id = $request['parent_id'];
			$theme_id = $request['theme_id'];
		
			$presentation_order = $request['presentation_order'];
			$urls = $request['url'];
			
			$active=0;
			$show_in_menu=0;
			$login_required=0;
			
			if(isset($request['active'])){
				$active=1;
			}
			if(isset($request['show_in_menu'])){
				$show_in_menu=1;
			}
			if(isset($request['login_required'])){
				$login_required=1;
			}
			
			$page = Page::find($page_id);
			$page->reference = $reference;
			$page->parent_id = $parent_id;
			$page->theme_id = $theme_id;
			
			$page->active = $active;
			
			$page->presentation_order = $presentation_order;
			$page->save();
			
			
			while(list($lang_id,$url)=each($urls)){
				
				if($url!=''){
					
					$pagemeta = $page->pagemetas()->where('language_id',$lang_id)->first();
					$language = Language::find($lang_id);
					
					if($pagemeta==null){
						
						//create pagemeta and add default route
						$pagemeta = new PageMeta();
						$pagemeta->name=$page->reference . " " . $language->shortname;
											
						$pagemeta->language_id=$language->id;
						$pagemeta->title=$page->reference . " " . $language->shortname;
						
						$pagemeta->description=$page->reference . " " . $language->shortname;
						$pagemeta->keywords=$page->reference . " " . $language->shortname;
						$pagemeta->page_id=$page->id;
						$pagemeta->save();
						
						
						$route = new Route();
						$route->page_meta_id = $pagemeta->id;
						$route->method='GET';
						$route->uri = $url;
						$route->controller_function = 'PageController@defaultpage';
						
						$route->save();
						
					}else{
						//update default route
						
						$route = $pagemeta->routes()->where('method','GET')->first();
						if($route!=null){
							
							$route->uri = $url;
							
							$route->save();
							
						}
						
					}
			
					
				}
			}
			
			
			header("Location: " . pagelink('pages',$language_id));
		}
	
		public function page_delete_page(){
			LoadView('admin/pages/page_delete.php');
		}
		
		public function page_delete($request){
			global $language_id;
			$page_id = $request["page_id"];
			$page = Page::find($page_id);
			
			$page->delete();
			
			$userrights = UserRight::where('name','view_' . $page->reference . '_page')->get();
			foreach($userrights as $userright){
				$userright->delete();
			}
			
			header("Location: " . pagelink('pages',$language_id));
			
		}
		
		
		public function pagemeta_add_page(){
			LoadView('admin/pages/pagemeta_add.php');
		}
		
		
		public function pagemeta_add($request){
			global $language_id;
			
			$page_id = $request['page_id'];
			$name = $request['name'];
			$title = $request['title'];
			$description = $request['description'];
			$keywords = $request['keywords'];
			$lang_id = $request['language_id'];
			$view_id = $request['view_id'];
			if($view_id=="0"){
				$view_id=null;
			}
			
			$page = Page::find($page_id);
			$parentpage = Page::find($page->parent_id);
			
			$meta = new PageMeta();
			$meta->page_id=$page_id;
			$meta->name=$name;	
			$meta->title=$title;
			$meta->description=$description;
			$meta->keywords=$keywords;
			$meta->language_id=$lang_id;
			$meta->view_id=$view_id;
			$meta->save();
			
			header("Location: " . pagelink('pages',$language_id));
		}
		
		public function pagemeta_edit_page(){
			LoadView('admin/pages/pagemeta_edit.php');
		}
		
		public function pagemeta_edit($request){
			global $language_id;
			
			$pagemeta_id = $request['pagemeta_id'];
			$name = $request['name'];
			
			$title = $request['title'];
			$description = $request['description'];
			$keywords = $request['keywords'];
			$view_id = $request['view_id'];
			if($view_id=="0"){
				$view_id=null;
			}
			
			$meta = PageMeta::find($pagemeta_id);
		
			$meta->name=$name;
			
			$meta->title=$title;
			$meta->description=$description;
			$meta->keywords=$keywords;
			$meta->view_id=$view_id;
			
			$meta->save();
			
			header("Location: " . pagelink('pages',$language_id));
			
		}

		
		public function page_posts_list() {
			global $parameters;
			global $language_id;
			global $site_config;
			global $html_helper;

			$urls = [
				'url_reorder' => pagelink("page_posts",$language_id,"POST","PageController@page_posts_reorder")
			];

			$html_helper->addJsVar($urls);
			
			$html_helper->addScript('<script src="'.$site_config['site_url']->value.'/js/admin_page_posts.js"></script>');

			$pages = Page::get();

			$page_id = isset($_REQUEST['page_id'])?$_REQUEST['page_id']:0;
			$page_posts = null;

			$html_helper->addJsVar(['page_id' => $page_id]);

			
			$posts = [];
			if (!empty($page_id)) {
				$page_posts = Post::join('post_page', 'post.id', '=', 'post_page.post_id')
				/*->join('post_detail', 'post.id', '=', 'post_detail.post_id')
				->where('post_detail.language_id', $language_id)*/
				->where('post_page.page_id', $page_id)
				->orderBy('post_page.presentation_order', 'ASC')
				->get(['post.*', 'post_page.presentation_order']);

				$posts = Post::get();

				/*echo '<pre>';
				print_r($posts);
				echo '</pre>';
				die();*/
			}

			$url_add_page_post = pagelink('page_posts',$language_id,"POST","PageController@page_posts_add");
			$url_unlink_page_post = pagelink('page_posts_unlink', $language_id);

			$template_vars = [
				'page_id' => $page_id,
				'page_posts' => $page_posts,
				'pages' => $pages,
				'posts' => $posts,
				'url_add_page_post' => $url_add_page_post,
				'url_unlink_page_post' => $url_unlink_page_post,
			];

			LoadView('admin/pages/page_posts_list.php', $template_vars);
		}	

		public function page_posts_reorder($request) {

			$page_id = isset($_POST['page_id'])?(int)$_POST['page_id']:0;
			$order = isset($_POST['sortable'])?$_POST['sortable']:[];

			if (!empty($page_id) && !empty($order)) {
				$presentation_order = 10;
				foreach($order as $post_id) {
					DB::table('post_page')->where('post_id', $post_id)
					->where('page_id', $page_id)
					->update(['presentation_order' => $presentation_order]);
					$presentation_order += 10;
				}
			}
		}	

		public function page_posts_add($request) {
			global $language_id;
			global $msg_helper;

			$page_id = isset($_POST['page_id'])?(int)$_POST['page_id']:0;
			$post_id = isset($_POST['post_id'])?(int)$_POST['post_id']:0;

			if (!empty($page_id) && !empty($post_id)) {
				try {
					DB::table('post_page')->insert(['post_id' => $post_id, 'page_id' =>$page_id]);
				} catch (Illuminate\Database\QueryException $e) {
					//duplicate error exception
				}
				
			}

			$msg_helper->set('messages', 1, ucfirst('the_item_has_been_added_succesfully'));

			$url_verder = pagelink('page_posts', $language_id);
			$url_verder .= '?page_id='.$page_id;
			header('Location:'.$url_verder);
			exit;
		}

		public function page_posts_unlink_page() {
			global $language_id;

			$page_id = isset($_REQUEST['page_id'])?$_REQUEST['page_id']:0;
			$post_id = isset($_REQUEST['post_id'])?$_REQUEST['post_id']:0;

			$template_vars = [
				'actionlink' => 'PageController@page_posts_unlink',
				'hidden_fields' => [
					'page_id' => $page_id,
					'post_id' => $post_id,
				]
			];
			LoadView('modals/delete.php', $template_vars);
		}

		public function page_posts_unlink() {
			global $language_id;
			global $msg_helper;

			$page_id = isset($_POST['page_id'])?$_POST['page_id']:0;
			$post_id = isset($_POST['post_id'])?$_POST['post_id']:0;

			if (!empty($page_id) && !empty($post_id)) {
				$page_post = DB::table('post_page')->where('page_id', $page_id)
				->where('post_id', $post_id)
				->delete();
			}

			$msg_helper->set('messages', 1, ucfirst(translate('the_item_has_been_deleted_succesfully')));

			$url_verder = pagelink('page_posts', $language_id);
			$url_verder .= '?page_id='.$page_id;
			header('Location:'.$url_verder);
			exit;
		}
	}
?>