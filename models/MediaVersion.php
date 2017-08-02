<?php

	class MediaVersion extends Illuminate\Database\Eloquent\Model {
		protected $table='media_version';
		

		public function media()
		{
			return $this->belongsTo('Media','media_id');
		}

		public function oldmedia()
		{
			return $this->belongsTo('Media','old_media_id');
		}
		
	}

?>