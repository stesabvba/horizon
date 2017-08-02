<?php

	class Translation extends Illuminate\Database\Eloquent\Model {
		protected $table='translation';

		protected $fillable = [
			'reference',
			'language_id',
			'translation',
			'type',
			'unstable',
		];
		
		public function language(){
			return $this->belongsTo('Language');
		}
	}

?>