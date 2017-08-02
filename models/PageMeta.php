<?php

	class PageMeta extends Illuminate\Database\Eloquent\Model {
		protected $table='page_meta';
		protected $guarded = array();
		
		public function page()
		{
			return $this->belongsTo('Page');
		}
		
	
		public function routes(){
			return $this->hasMany('Route');
		}
		
		public function language(){
			return $this->belongsTo('Language');
		}

		public function defaulturi(){
			$route = $this->routes()->where('method','GET')->first();
			
			if($route!=null){
				return $route->uri;
			}else{
				
				return "";
			}
		}
		
		public function defaultroute()
		{
			$route = $this->routes()->where('method','GET')->first();
			
			return $route;
		}
		
		public function view()
		{
			return $this->belongsTo('View');
		}
	}

?>