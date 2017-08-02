<?php

	class Profile extends Illuminate\Database\Eloquent\Model {
		protected $table='profile';
		
		public function user()
		{
			return $this->hasMany('User');
		}
		
		public function userrights()
		{
			return $this->belongsToMany('UserRight','profile_userright','profile_id','userright_id');
		}


		public function reports()
		{
			return $this->belongsToMany('Report','report_profile');
		}
	}

?>