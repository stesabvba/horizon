<?php

	class MenuItem extends Illuminate\Database\Eloquent\Model {
		protected $table='menu_item';
		
		public function menu()
		{
			return $this->belongsTo('Menu');
		}
		
		public function pagemeta()
		{
			return $this->belongsTo('PageMeta','page_meta_id');
		}
	}

?>