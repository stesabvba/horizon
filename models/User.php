<?php

	
	class UserRight extends Illuminate\Database\Eloquent\Model {
		protected $table='userright';
		protected $guarded = array();
		
		public function usergroups()
		{
			return $this->belongsToMany('Usergroup');
		}
	}
	
	
	
	class User extends Illuminate\Database\Eloquent\Model {
		protected $table='user';

		protected $fillable = [
		'name',
		'firstname',
		'lastname',
		'email',
		'phone',
		'company',
		'username',
		'password',
		'password_resetkey',
		'profile_id',
		'communication_language_id',
		'active',
		'lastloggedin_at',	
		];
		
		
		public function profile()
		{
			return $this->belongsTo('Profile');
		}
		
		public function communicationlanguage()
		{
			return $this->belongsTo('Language','communication_language_id');
		}
		
		public function customers()
		{
			return $this->belongsToMany('Customer','user_customer');
		}


		public function mailinglists()
		{
			return $this->belongsToMany('Mailinglist','user_mailinglist');
		}


	
		
		public function can($userright_name)
		{
			$result=false;
			$userright = UserRight::where('name',$userright_name)->first();
			if($userright!=null){

				if($this->profile->userrights->where('id',$userright->id)->first()!=null){
					$result = true;
				}
			}
			
			return $result;
		}
		
		public function fullname(){
			return $this->firstname . " " . $this->lastname;
		}

		public function can_order() {
			//returns true or false
			$b_can_order = false;
			if (in_array($this->profile->name, ['admin', 'dealer'])) {
				if ($this->customers->count() > 0) {
					$b_can_order = true;
				}
			}
			return $b_can_order;
		}

		public function has_profile($profile_name) {
			if ($this->profile == null) {
				return false;
			}

			if ($this->profile->name == $profile_name) {
				return true;
			}

			return false;
		}
	}

?>