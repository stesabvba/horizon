<?php

	class Route extends Illuminate\Database\Eloquent\Model {
		protected $table='route';
		protected $guarded = array();
		
		public function pagemeta()
		{
			return $this->belongsTo('PageMeta','page_meta_id');
		}
	}

?>