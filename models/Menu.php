<?php

	class Menu extends Illuminate\Database\Eloquent\Model {
		protected $table='menu';
		
		
		public function menu_items()
		{
			return $this->hasMany('MenuItem');
		}
	}

?>