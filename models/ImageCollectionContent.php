<?php

	class ImageCollectionContent extends Illuminate\Database\Eloquent\Model {
		protected $table='image_collection_content';

		protected $guarded = [];
	
		public function media()
		{
			return $this->belongsTo('Media');
		}	
	}

?>