<?php
	class RouteController extends BaseController {
		
		public function route_add_page(){
			LoadView('admin/routes/route_add.php');
		}
		
		public function route_add($request){
			
			global $language_id;
			
			$page_id = $request['page_id'];
			$page_meta_id = $request['page_meta_id'];
			$method = $request['method'];
			$uri = $request['uri'];
			$controller_function = $request['controller_function'];
			
			$load_default_view = 0;
			
			if(isset($request['load_default_view'])){
				$load_default_view=1;
			}
			
			$route = new Route();
			$route->page_meta_id=$page_meta_id;
			$route->method = $method;
			$route->uri = $uri;
			$route->controller_function = $controller_function;
			
			$route->save();
			
			header('Location: ' . pagelink('page_edit',$language_id) . '/' . $page_id);
			
		}
		
		
		public function route_edit_page(){
			LoadView('admin/routes/route_edit.php');
		}
		
		public function route_edit($request){
			global $language_id;
			$route_id = $request['route_id'];
			$page_id = $request['page_id'];
			$page_meta_id = $request['page_meta_id'];
			$method = $request['method'];
			$uri = $request['uri'];
			$controller_function = $request['controller_function'];
			
			$load_default_view = 0;
			
			if(isset($request['load_default_view'])){
				$load_default_view=1;
			}
			
			$route = Route::find($route_id);
			$route->page_meta_id=$page_meta_id;
			$route->method = $method;
			$route->uri = $uri;
			$route->controller_function = $controller_function;
		
			$route->save();
			
			header('Location: ' . pagelink('page_edit',$language_id) . '/' . $page_id);
		}
		
		public function route_copy_page(){
			LoadView('admin/routes/route_copy.php');
		}
		
		public function route_copy($request){
			global $language_id;
			$route_id = $request['route_id'];
			$page_id = $request['page_id'];
			$page_meta_id = $request['page_meta_id'];
			$method = $request['method'];
			$uri = $request['uri'];
			$controller_function = $request['controller_function'];
			
			
			
			$route = new Route();
			$route->page_meta_id=$page_meta_id;
			$route->method = $method;
			$route->uri = $uri;
			$route->controller_function = $controller_function;
			
			$route->save();
			
			header('Location: ' . pagelink('page_edit',$language_id) . '/' . $page_id);
		}
		
		
		public function route_delete_page(){
			LoadView('admin/routes/route_delete.php');
		}
		
		
		public function route_delete($request){
			global $language_id;
			$route_id = $request['route_id'];
			
			
			$page_id = $request['page_id'];
			
			$route = Route::find($route_id);
			
			$pagemeta = $route->pagemeta;
			
			$page_id = $pagemeta->page_id;
			$route->delete();
			
			header('Location: ' . pagelink('page_edit',$language_id) . '/' . $page_id);
		}
	}



?>