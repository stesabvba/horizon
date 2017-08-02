<?php
	require('BaseController.php');

	use Illuminate\Pagination\Paginator;
	use Illuminate\Pagination\LengthAwarePaginator;
	use Illuminate\Database\Capsule\Manager as DB;

	class MediaController extends \App\BaseController {

		private $_default_image_formats = [
			'original',
			'thumbnail',
			'small',
			'medium',
			'large',
		];

		public function medialibrary(){
			global $language_id, $html_helper,$site_config;
			$html_helper->addScript('<script src="'.$site_config['site_url']->value.'/js/medialibrary.js"></script>');

			
			$html_helper->addJsVar([
					'medialist_url'=>pagelink('medialibrary',$language_id,'POST','MediaController@medialist'),
					'upload_url'=>pagelink('medialibrary',$language_id,'POST','MediaController@media_add'),
					'overwrite_url'=>pagelink('medialibrary',$language_id,'POST','MediaController@media_overwrite'),

					]


				);


			
			$tags = Tag::all();

			$template_vars=["tags" => $tags];

			LoadView('admin/media/medialibrary.php',$template_vars);
		}


		public function medialist($request)
		{
			global $language_id, $html_helper,$site_config,$active_route;

			if(isset($_POST['search']) && !empty($_POST['search']))
			{

				if(isset($_POST['search_tags']) && $_POST['search_tags']!="null")
				{
					$search_tags = explode(',',$_POST['search_tags']);
			
					$medias = Media::where('visible',1)
							->where('name','LIKE',"%" . $_POST['search'] . "%");

					foreach($search_tags as $search_tag)
					{
						$medias=$medias->whereHas('tags',function($query) use($search_tag){ 
							$query->where('tag_id',$search_tag);
						});
					}
						
					$medias=$medias->orderBy("id","desc")->paginate(20);

				}
				else
				{
					$medias = Media::where('visible',1)
							->where('name','LIKE',"%" . $_POST['search'] . "%")
							->orderBy("id","desc")->paginate(20);
				}
				

			}else{

				if(isset($_POST['search_tags']) && $_POST['search_tags']!="null")
				{
					
					$search_tags = explode(',',$_POST['search_tags']);
			
					$medias = Media::where('visible',1);

								foreach($search_tags as $search_tag)
								{
									$medias=$medias->whereHas('tags',function($query) use($search_tag){ 
										$query->where('tag_id',$search_tag);
									});
								}
								
								$medias=$medias->orderBy("id","desc");
								//dd($medias->toSql());
								$medias=$medias->paginate(20);
					

				}
				else
				{

					$medias = Media::where('visible',1)->orderBy("id","desc")->paginate(20);
				}

				
			}

			//$medias = Media::where('id', '>=', 5627)->orderBy("id","desc")->paginate(200);
			

			//dd($medias->elements);
			//$medias = Media::where('id', '>=', 5824)->orderBy("id","desc")->paginate(200); // tmp david
			

			$paginator=$this->GetPaginatorLinks($active_route,$medias->elements());

			$delete_pagelink=pagelink('media_delete',$language_id);
			$format_add_pagelink=pagelink("media_format_add",$language_id);
			$tag_pagelink=pagelink("media_tag",$language_id);

			$types_images = ['image/png', 'image/gif', 'image/jpeg'];

			$template_vars = [
				'medias' => $medias,
				'delete_pagelink' => $delete_pagelink,
				'format_add_pagelink' => $format_add_pagelink,
				'tag_pagelink' => $tag_pagelink,
				'types_images' => $types_images,
				'default_image_formats' => $this->_default_image_formats,
				'load_theme' => false,
				'paginator' => $paginator
			];

			LoadView('admin/media/medialist.php',$template_vars);
		}

		public function media_tags_page()
		{
			global $parameters;
			$media_id=$parameters[0];
			$media=Media::find($media_id);
			$tags = Tag::all();
			$media_tags = $media->tags;

			$template_vars = [
				'media_id' => $media_id,
				'tags' => $tags,
				'media_tags' => $media_tags,
				'actionlink' => actionlink('MediaController@media_tags',0)
			];

			LoadView("admin/media/media_tags.php",$template_vars);

		}

		public function media_tags($request)
		{
			global $language_id;

			$tag_ids = $request['tags'];
			$media_id = $request['media_id'];
			$media=Media::find($media_id);

			$media->tags()->detach();

			foreach($tag_ids as $tag_id)
			{
			
				$media->tags()->attach($tag_id);
			}

			header('Location: ' . pagelink('medialibrary',$language_id));
		}
		
	
		
		public function media_insert_page(){
			LoadView('admin/media/media_insert.php');
		}

		public function media_format_add_page()
		{
			global $parameters;

			$media_id = $parameters[0];

			$template_vars = [
					'actionlink' => actionlink('MediaController@media_format_add',0),
					'media_id' => $media_id
				];

			LoadView('admin/media/media_format_add.php',$template_vars);

		}

		public function media_format_add($request)
		{
			global $language_id;

			$media_id = $request["media_id"];
			$format_name = $request["name"];
			$format_width = $request["width"];
			$format_height = $request["height"];

			$keep_ratio = 0;
			if(isset($request["keep_ratio"]))
			{
				$keep_ratio = 1;
			}

			$media = Media::find($media_id);

			$meta = $media->meta()->where('meta_name','image_versions')->first();
			$image_versions = json_decode($meta->meta_value);
			$image_versions = is_array($image_versions)?$image_versions:[];

	
			$image_versions = json_decode($meta->meta_value,true);

			$uploadpath = $image_versions['original'][2];
			
			if(!isset($image_versions["$format_name"])){
				$image_versions["$format_name"]= resize_image($media->media_type,$uploadpath,$format_width,$format_height,$keep_ratio);
		
				$meta->meta_value = json_encode($image_versions);
				$meta->save();

			}else{
				unlink($image_versions["$format_name"][2]); //delete previous file

				$image_versions["$format_name"]= resize_image($media->media_type,$uploadpath,$format_width,$format_height,$keep_ratio);
		
				$meta->meta_value = json_encode($image_versions);
				$meta->save();

			}

			header('Location: ' . pagelink('medialibrary',$language_id));
		}
		
		public function media_insert($request){
			global $site_config;
			
			$media_id = $request["media_id"];
			
			$media = Media::find($media_id);
			
			
			switch($media->media_type){
				case "image/png":
				case "image/gif":
				case "image/jpeg":
				
					$meta = $media->meta()->where('meta_name','image_versions')->first();
					
					if($meta!=null){
					
						$image_versions = json_decode($meta->meta_value,true);
						
						$version = $request["version"];
						
						$image_version = $image_versions[$version];
						$image_path = $image_version[2];
				
						echo("<img src='" . $site_config["site_url"]->value . "$image_path'/>");
					}
					
					break;
				
				default:
				
					echo("<a href='" . $site_config["site_url"]->value . $media->filename . "'>" . $media->name . "</a>");
				
					break;
			}
		}
		
		public function getmediameta($request){
			
			$output="";
			
			$media_id = $request["media_id"];
			
			
			$media = Media::find($media_id);
			
			$output.=$media->filename;
			
			switch($media->media_type){
				
				case "image/png":
				case "image/gif":
				case "image/jpeg":
				
				$meta = $media->meta()->where('meta_name','image_versions')->first();
				
				if($meta!=null){
				
					$image_versions = json_decode($meta->meta_value,true);
					
					$output.="<select name='version'>";
					
					while(list($version_name, $image_version) = each($image_versions)){
						
						$image_width = $image_version[0];
						$image_height = $image_version[1];
						
						$output.="<option value='$version_name'>$version_name ($image_width x $image_height)</option>";
					}
					
					$output.="</select>";
				}
				break;
				
			}
			
			echo $output;
		}
		
		/*public function resize_image($image_type, $image_path, $resize_width, $resize_height, $keep_ratio){
			
			$image = new Imagick($image_path);
		
			if($keep_ratio==1){
	

				$image->resizeImage($resize_width, $resize_height,Imagick::FILTER_LANCZOS,1,true);
				$resize_width = $image->getImageWidth();
				$resize_height = $image->getImageHeight();
				
			}else{
				//crop
				
				$image->thumbnailImage($resize_width, $resize_height,true);
				
			}
			$resized_image_path = substr($image_path,0,strpos($image_path,'.')) . "-" . $resize_width . "x" . $resize_height. substr($image_path,strpos($image_path,'.'));
			
			
			$image->writeImage($resized_image_path);
			
			return array($resize_width, $resize_height, $resized_image_path);			
		}*/

		private function update_meta($media_id, $meta_name) {
			$media = Media::find($media_id);

			if (is_null($media)) {
				return;
			}

			if (!in_array($meta_name, ['image_width', 'image_height', 'image_versions'])) {
				return;
			}

			$uploadpath = $media->filename;
			$meta = $media->meta()->where('meta_name', $meta_name)->first();
			if (is_null($meta)) {
				$meta = new MediaMeta();
				$meta->media_id = $media_id;
				$meta->meta_name = $meta_name;
			}

			$valid_mediatypes = [
				'image/png',
				'image/gif',
				'image/jpeg',
			];

			if (in_array($media->media_type, $valid_mediatypes)) {
				switch($meta_name) {
					case 'image_width':
						$image_size = getimagesize($uploadpath);											
						$width = $image_size[0];
						$height = $image_size[1];	

						$meta->meta_value = $width;
					break;
					
					case 'image_height':
						$image_size = getimagesize($uploadpath);					
						$width = $image_size[0];
						$height = $image_size[1];	

						$meta->meta_value = $height;
					break;

					case 'image_versions':
						$image_versions = json_decode($meta->meta_value);
						$image_versions = is_array($image_versions)?$image_versions:[];
						foreach($this->_default_image_formats as $version) {
							if (!isset($image_versions->{$version})) {
								switch($version) {
									case 'original':
										$image_size = getimagesize($uploadpath);					
										$width = $image_size[0];
										$height = $image_size[1];	

										$image_versions["original"]=array($width, $height, $uploadpath);
									break;

									case 'thumbnail':
										$image_versions["thumbnail"]= resize_image($media->media_type,$uploadpath,150,150,0);
									break;

									case 'small':
										$image_versions["small"]= resize_image($media->media_type,$uploadpath,290,290,1); //col-md-3
									break;

									case 'medium':
										$image_versions["medium"]= resize_image($media->media_type,$uploadpath,580,580,1); //col-md-6
									break;

									case 'large':
										$image_versions["large"]= resize_image($media->media_type,$uploadpath,1170,1170,1); //col-md-12
									break;
								}
							}
						}
						$meta->meta_value = json_encode($image_versions);
					break;
				}
			}
			$meta->save();				
		}

		public function media_scan($request) {
			global $language_id;

			set_time_limit(120);

			$selected_items = isset($request['selected_items'])?$request['selected_items']:[];

			if (!isset($_SESSION['tmp_last_scan'])) {
				$_SESSION['tmp_last_scan'] = 7206;
			}

			$_SESSION['tmp_last_scan'] += 20;

			//$selected_items = Media::where('id', '>=', $_SESSION['tmp_last_scan'])->take(20)->pluck('id')->toArray();

			if (!empty($selected_items)) {
				foreach($selected_items as $id_item) {
					//$media = Media::orderBy('id', 'DESC')->take(50)->get();	
					$media = Media::where('id', $id_item)->get();
					if (!empty($media)) {
						foreach($media as $item) {
							$uploadpath = $item->filename;
							if (is_file($uploadpath)) {
								if (!$item->has_meta('image_width')) {
									self::update_meta($item->id, 'image_width');
								}

								if (!$item->has_meta('image_height')) {
									self::update_meta($item->id, 'image_height');
								}
								self::update_meta($item->id, 'image_versions');
							}
						}
					}
				}
			}

			header('Location: ' . pagelink('medialibrary',$language_id));
			exit;
		}

		public function media_add($request){
			global $language_id;


			$media = UploadMediaItem($_FILES);

			if(isset($request['tags']))
			{
			$tag_ids = explode(',',$request['tags']);
			
			foreach($tag_ids as $tag_id)
			{
				if($tag_id!=null)
				{	
					
					$media->tags()->attach($tag_id);
				}
				
			}

			}


			//header('Location: ' . pagelink('medialibrary',$language_id));
		}

		public function media_overwrite($request){
			global $language_id;

			//dd($request);

			$old_media_id = $request["media_id"];

			$old_media = Media::find($old_media_id);

			$new_media = $old_media->replicate();
			$new_media->visible=0;
			$new_media->save();

			foreach($old_media->meta as $old_meta)
			{
				$new_meta = $old_meta->replicate();
				$new_meta->media_id = $new_media->id;
				$new_meta->save();
			}
			

			$mv = new MediaVersion();

			$mv->media_id = $old_media->id;
			$mv->old_media_id = $new_media->id;
			$mv->save();




			OverwriteMediaItem($old_media);

			//tags switchen



			//meta switchen
			

			//header('Location: ' . pagelink('medialibrary',$language_id));
		}
		
		
		public function media_delete_page(){
			LoadView('admin/media/media_delete.php');
		}
		
		public function media_delete($request){
			global $language_id;
			
			$media_id = $request['media_id'];
			
			$media = Media::find($media_id);

			foreach($media->versions as $version)
			{
				$version->oldmedia->full_delete();
			}
			
			$media->full_delete();
			
			header('Location: ' . pagelink('medialibrary',$language_id));
		}


		public function download_media()
		{
			global $parameters,$site_config;

			$media_id=$parameters[0];

			$media = Media::find($media_id);

			if($media!=null)
			{
				header("Content-type: " . $media->media_type);
				header('Content-Disposition: attachment; filename='.basename($media->name));

				readfile($media->filename);

				//echo($site_config["site_url"]->value . urlencode($media->filename));
			}
		}

		public function media_tags_reorder_page() {
			global $html_helper;
			global $site_config;
			global $language_id;

			$urls = [
				'url_reorder' => pagelink("media_tags_reorder",$language_id,"POST","MediaController@media_tags_reorder")
			];
			$html_helper->addJsVar($urls);

			$html_helper->addScript('<script src="'.$site_config['site_url']->value.'/js/admin_media_tags_reorder.js?'.time().'"></script>');

			$languages = Language::orderBy('name', 'ASC')->get();		
			$lang_id = isset($_REQUEST['lang_id'])?$_REQUEST['lang_id']:'';

			$tags = collect([]);

			if (!empty($lang_id)) {
				$tags = Tag::where('language_id', $lang_id)->orderBy('presentation_order', 'ASC')->get();
			} else {
				$tags = Tag::orderBy('presentation_order', 'ASC')->get();
			}

			$template_vars = [
				'lang_id' => $lang_id,
				'languages' => $languages,
				'tags' => $tags,
			];

			LoadView('admin/media/media_tags_reorder_page.php', $template_vars);
		}

		public function media_tags_reorder() {
			$order = isset($_POST['sortable'])?$_POST['sortable']:[];
			if (!empty($order)) {
				$presentation_order = 10;
				foreach($order as $tag_id) {
					$tag = Tag::find($tag_id);
					if ($tag != null) {
						$tag->presentation_order = $presentation_order;
						$tag->save();
					}
					$presentation_order += 10;
				}
			}
		}

		/*
		public function media_tags_reorder_page() {
			global $language_id;
			global $html_helper;
			global $site_config;

			$urls = [
				'url_reorder' => pagelink("media_tags_reorder",$language_id,"POST","MediaController@media_tags_reorder")
			];
			$html_helper->addJsVar($urls);
			$html_helper->addScript('<script src="'.$site_config['site_url']->value.'/js/admin_media_tags_reorder.js?'.time().'"></script>');

			$tag_id = isset($_REQUEST['tag_id'])?$_REQUEST['tag_id']:0;
			$html_helper->addJsVar(['tag_id' => $tag_id]);

			$parent_tag_id = isset($_REQUEST['parent_tag_id'])?$_REQUEST['parent_tag_id']:0;

			$tags = Tag::whereHas('language')->with('language')->orderBy('name', 'ASC')->get();

			$tag = null;
			if (!empty($tag_id)) {
				$tag = Tag::find($tag_id);
			}*/

			/*
			$media_tags = [];
			$ddl_parent_tag_ids = [];
			if ($tag != null) {
				
				$medias = $tag->medias()->withPivot(['id', 'presentation_order'])->orderBy('media_tag.presentation_order', 'ASC')->get();
				foreach($medias as $media)
				{
					$tmp_media_tags = $media->tags()->orderBy('presentation_order', 'ASC')->get();	
					foreach($tmp_media_tags as $t)
					{
						if($t->language_id==$tag->language_id){
							if(!isset($media_tags[$t->id])){
								$media_tags[$t->id] = [];
							}
							array_push($media_tags[$t->id], $media);
						}
					}
				}
				unset($media_tags[$tag_id]);*/

				/*$ddl_parent_tag_ids = array_keys($media_tags);
				if (!empty($parent_tag_id)) {
					$tmp_keys = array_keys($media_tags);
					foreach($tmp_keys as $key) {
						if ($key != $parent_tag_id) {
							unset($media_tags[$key]);
						}
					}
				}	*/
			//}

			/*if (!empty($media_tags[36])) {
				foreach($media_tags[36] as $media) {
					echo 'media.id='.$media->id.' - pivot='.$media->pivot->id;
					echo '<br />';
				}

				$tmp = Tag::find(36)->medias()->withPivot(['id'])->get();
				if (!empty($tmp)) {
					foreach($tmp as $item) {
						echo 'media.id='.$item->id.' - pivot='.$item->pivot->id;
						echo '<br />';
						echo '<pre>';
						print_r($item);
						echo '</pre>';
						die();						
					}
				}
			}
*/
			/*$ddl_parent_tags = collect([]);
			if (!empty($ddl_parent_tag_ids)) {
				$ddl_parent_tags = Tag::whereIn('id', $ddl_parent_tag_ids)->whereHas('language')->with('language')->orderBy('name', 'ASC')->get();
			}*/

			/*$template_vars = [
				'tags' => $tags,
				'tag_id' => $tag_id,
				'parent_tag_id' => $parent_tag_id,
				'media_tags' => $media_tags,
				//'ddl_parent_tags' => $ddl_parent_tags,
			];
			LoadView('admin/media/media_tags_reorder_page.php', $template_vars);*/
		//}

		/*public function media_tags_reorder($request) {
			$order = isset($_POST['sortable'])?$_POST['sortable']:[];

			echo '<pre>';
			print_r($order);
			echo '</pre>';
			die();
			if (!empty($order)) {
				$presentation_order = 10;
				foreach($order as $tag_id) {
					
					echo $tag_id.'-'.$presentation_order;
					echo '<br />';
					DB::table('media_tag')
					->where('tag_id', $tag_id)
					->update(['presentation_order' => $presentation_order]);
					$presentation_order += 10;
				}
			}
		}*/	
	}
?>