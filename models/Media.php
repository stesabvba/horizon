<?php

	class Media extends Illuminate\Database\Eloquent\Model {
		protected $table='media';
		

		public function versions(){
			return $this->hasMany('MediaVersion');
		}


		public function meta(){
			return $this->hasMany('MediaMeta');
		}

		public function tags()
		{
			return $this->belongsToMany('Tag','media_tag');
		}

		public function image_versions() {
			$image_versions = [];

			$o_image_versions = $this->meta()->where('meta_name', 'image_versions')->first();

			if (!empty($o_image_versions)) {
				$image_versions = json_decode($o_image_versions->meta_value);
			}
			return $image_versions;
		}

		public function has_meta($meta_name) {
			return !is_null($this->meta->where('meta_name', $meta_name)->first());
		}

		public function full_delete() {
			//ook de meta + fysieke afbeeldingen verwijderen
			switch($this->media_type){	
				
				case "image/png":		
				case "image/gif":
				case "image/jpeg":

					$meta = $this->meta()->where('meta_name','image_versions')->first();
				
					if($meta!=null){
				
						$image_versions = json_decode($meta->meta_value,true);
					
						foreach($image_versions as $image_version){
							if (is_file($image_version[2])) {
								unlink($image_version[2]); //delete file
							}
						}
					}
					break;
				
				
				default:
					unlink($this->filename);
					break;
			}

			$this->delete();
		}
	}

?>