<?php

	class Tag extends Illuminate\Database\Eloquent\Model {
		protected $table='tag';

		public function medias()
		{
			return $this->belongsToMany("Media","media_tag");
		}


		public function language()
		{
			return $this->belongsTo('Language');
		}

		public function children() {
			return $this->belongsToMany('Tag', 'tag_parents', 'parent_tag_id', 'tag_id');
		}		
	}

?>