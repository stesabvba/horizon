<?php

	class Page extends Illuminate\Database\Eloquent\Model {
		protected $table='page';
		protected $guarded = array();
		
		public function pagemetas()
		{
			return $this->hasMany('PageMeta');
		}
		
		public function theme()
		{
			return $this->belongsTo('Theme');
		}
		
		public function children()
		{
			return Page::where('parent_id',$this->id)->get();
		}
		
		public function posts()
		{
			return $this->belongsToMany('Post', 'post_page');
		}

		public function title($language_id){
			$ret = '';
			$meta = $this->pagemetas()->where('language_id', $language_id)->first();
			if (!is_null($meta)) {
				$ret = $meta->title;				
			}
			return $ret;
		}		
	}

?>