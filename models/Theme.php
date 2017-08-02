<?php

	class Theme extends Illuminate\Database\Eloquent\Model {
		protected $table='theme';
		
		
		public function page()
		{
			return $this->hasMany('Page');
		}
		
	}

?>