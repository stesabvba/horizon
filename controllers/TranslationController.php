<?php
use Illuminate\Database\Capsule\Manager as DB;

	class TranslationController extends BaseController
	{


		public function toggle_inline_translations($request){
			global $language_id, $site_config;
			
			if($site_config['inline_translations_active']->value==1){
				$site_config['inline_translations_active']->value=0;
			}else{
				$site_config['inline_translations_active']->value=1;
			}
			
			$site_config['inline_translations_active']->save();
		
			header("Location: " . pagelink('translations',$language_id));
		}
			
		public function translation_add($request){
			global $language_id;

			$reference = !empty($request['reference'])?$request['reference']:'';
			
			if (strlen(trim($reference)) > 0) {
				$reference = $request["reference"];
				$type = $request["type"];
				$translations = $request["translations"];
				while(list($key,$value)=each($translations)){
					
					$t = new Translation();
					$t->reference = $reference;
					$t->language_id=$key;
					$t->type = $type;
					$t->unstable = 1;
					$t->translation = $value;
					$t->save();				
				}
			}
						
			header("Location: " . pagelink('translations',$language_id));
		}

		public function translation_add_page(){
			global $parameters;
			global $html_helper;
			global $site_config;
			global $globals;
			global $language_id;

			$languages = Language::all();
			$translations = [];
			if (!empty($languages)) {
				foreach($languages as $language) {

					$t = new Translation();
					$t = new Translation();
					$t->language = $language;

					$translations[$language->shortname] = $t;
				}
			}

			$field_types = [
				1 => translate('term'),
				2 => translate('text'),
			];

			$template_vars = [
				'actionlink' => 'TranslationController@translation_add',
				'translation' => new Translation(),
				'translations' => $translations,
				'field_types' => $field_types,
			];
			LoadView('admin/translations/translation_edit.php', $template_vars);
		}


		public function GetNextNumber($table,$column)
		{
		

			$query = "SELECT next_seq FROM servoy_columninfo WHERE connection_name='user_data' AND tablename='$table' AND columnname='$column';";

			

			$result = DB::connection('vision_repository')->select($query);

			

			return($result[0]->next_seq);
			
		}

		public function SetNextNumber($table,$column,$number)
		{
		

			$query = "UPDATE servoy_columninfo SET next_seq=$number WHERE connection_name='user_data' AND tablename='$table' AND columnname='$column';";

			
			$result = DB::connection('vision_repository')->update($query);

					
		}
		
		public function translation_edit_page(){
			global $parameters;
			global $html_helper;
			global $site_config;
			global $globals;
			global $language_id;


			$vision_references = array("article_name_","article_price_description_","product_name_","product_feature_name_","product_option_name_");

			$vision_translation = 0;

			$translation_id = isset($parameters[0])?$parameters[0]:0;
			$translation = Translation::find($translation_id);
			if ($translation==null) {
				header("Location:".pagelink('translations',$language_id));
				exit;
			}

			$languages = Language::all();
			$translations = [];

			foreach($vision_references as $vision_reference){
				
				if(strpos($translation->reference,$vision_reference)!==false)
				{
					$vision_translation=1;
					
					break;
				}

			}
			if (!empty($languages)) {
				foreach($languages as $language) {
					$t = Translation::where('reference',$translation->reference)->where('language_id',$language->id)->first();

					if (empty($t)) {
						$t = new Translation();
						$t->language = $language;
					}
					$translations[$language->shortname] = $t;
				}
			}

			$field_types = [
				1 => translate('term'),
				2 => translate('text'),
			];

			$template_vars = [
				'actionlink' => 'TranslationController@translation_edit',
				'translation' => $translation,
				'translations' => $translations,
				'field_types' => $field_types,
				'vision_translation' => $vision_translation
			];
			LoadView('admin/translations/translation_edit.php', $template_vars);
		}
		
		public function translation_edit($request){			
			global $language_id;

			$vision_translation = $request['vision_translation'];
			$reference = $request["reference"];
			$type = $request["type"];

			if(isset($request["needs_review"]))
			{
				$needs_review = $request['needs_review'];	
			}else
			{
				$needs_review = array();
			}

			
			$translations = !empty($request["translations"])?$request["translations"]:[];

			if (!empty($translations)) {
				foreach($translations as $lang_id => $translation_val) {
					$t = Translation::where('reference',$reference)->where('language_id',$lang_id)->first();
					
					if(isset($needs_review[$lang_id]))
					{
						$unstable = 1;
					}else{
						$unstable = 0;
					}
					

					$data = [
						'reference' => $reference,
						'language_id' => $lang_id,
						'translation' => $translation_val,
						'type' => $type,
						'unstable' => $unstable
					];

					$t->fill($data);
					if ($t == null) {					
						$t->save();
					} else {
						$t->update();
					}
				}	
			}

			if($vision_translation==1)
			{

				foreach($translations as $lang_id => $translation_val) {


					switch($reference)
					{
						case strpos($reference,"article_name_")!==false :

							$article_id = str_replace("article_name_","",$reference);


							if($lang_id==1)
							{

								$va = VisionArticle::find($article_id);

								if($va!=null && $va->name!=$translation_val)
								{
									$va->name = $translation_val;
									$va->save();
								}else{
									//echo($va->name);
								}

							}else{

								$vt = VisionTranslation::where('origin_type','art_article')->where('origin_field_name','name')->where('origin_id',$article_id)->where('glb_language_id',$lang_id)->first();

								if($vt!=null && $vt->translation_txt!=$translation_val)
								{
									$vt->translation_txt=$translation_val;
									$vt->save();
								}else{
									//echo($vt->translation_txt);
								}
							

							}
					

						break;

						case strpos($reference,"product_option_name_")!==false :

							$product_id = str_replace("product_option_name_","",$reference);

							$product_option = VisionProductOption::find($product_id);

							if($product_option!=null)
							{
								if($lang_id==1)
								{
									if($product_option->name!=$translation_val)
									{

										$vt = VisionTranslation::where('origin_type','ord_product_option')->where('origin_field_name','name')->where('origin_id',$product_id)->where('glb_language_id',$lang_id)->first();

										if($vt!=null)
										{
											if($vt->translation_txt!=$translation_val)
											{
												$vt->translation_txt=$translation_val;
												$vt->save();
											}else{
												echo($vt->translation_txt);
											}

											
										}else{
											//create translation entry

											$vt = new VisionTranslation();
											$vt->origin_type="ord_product_option";
											$vt->origin_field_name="name";
											$vt->origin_id=$product_id;
											$vt->owner_id="1F42F30D-8862-4F3B-AA8D-E7B6E9C65184";
											$vt->log_creation_user="admin";
											$vt->glb_language_id = $lang_id;

											$next_id = $this->GetNextNumber("glb_translation","glb_translation_id");

											$vt->glb_translation_id = $next_id;
											$vt->save();

											$this->SetNextNumber("glb_translation","glb_translation_id",$next_id+1);		

											die('ik maak een vertaling aan');							
										}

									}
									

								}else{
									$vt = VisionTranslation::where('origin_type','ord_product_option')->where('origin_field_name','name')->where('origin_id',$product_id)->where('glb_language_id',$lang_id)->first();

									if($vt!=null && $vt->translation_txt!=$translation_val)
									{
										$vt->translation_txt=$translation_val;
										$vt->save();
									}else{
										echo($vt->translation_txt);
									}
								}
							}

							

						

						break;
					}

				}

				
			}
			
			header("Location: " . $_SERVER['HTTP_REFERER']);
			exit;
		}
		
		public function translation_delete_page(){
			LoadView('admin/translations/translation_delete.php');
		}
		
		public function translation_delete($request){
			global $language_id;
			$translation_id=$request['translation_id'];
			
			$t = Translation::find($translation_id);
			
			$translations = Translation::where('reference',$t->reference)->where('type',$t->type)->get();
			
			foreach($translations as $translation){
				$translation->delete();
				
			}
			
			header("Location: " . pagelink('translations',$language_id));
		}
	
		
		public function translation_get($request){
			global $language_id;
			
			$translation_id=$request["translation_id"];
			
			$translation = Translation::find($translation_id);
			$type = $translation->type;
			$reference = $translation->reference;
			
			$translations = Translation::where('reference',$reference)->where('type',$type)->get();
			
			echo($translations->toJson());
		}
		
	
		public function translations(){
			global $html_helper;
			global $site_config;
			global $globals;
			global $active_pagemeta;
			global $language_id;


			$urls = [
				'translationlist_url' => pagelink("translations",$language_id,"POST","TranslationController@translations_list")
						
			];

			$html_helper->addJsVar($urls);


			$html_helper->addScript('<script src="'.$site_config['site_url']->value.'/js/admin_translations.js"></script>');

			$template_vars=[];

			LoadView('admin/translations/translations.php', $template_vars);
		}

		public function translations_list($request)
		{
			global $language_id, $active_route;

			$translation_type = $request['translation_type'];


			if(isset($_POST['search']) && !empty($_POST['search']))
			{

				switch($translation_type){
					case 1:

						$translations = Translation::where('reference','LIKE','%' . $_POST['search'] . '%')
											->orwhere('translation','LIKE','%' . $_POST['search'] . '%')
											->paginate(20);
						break;

					case 2:

						$translations = Translation::where('reference','LIKE','%' . $_POST['search'] . '%')
											->where('unstable',1)
											->orwhere('translation','LIKE','%' . $_POST['search'] . '%')
											->paginate(20);

						break;


					case 3:

						$translations = Translation::where('reference','LIKE','%' . $_POST['search'] . '%')
											->where('unstable',0)
											->orwhere('translation','LIKE','%' . $_POST['search'] . '%')
											->paginate(20);

						break;
				}
				

			}else{

				switch($translation_type){
					case 1:

						$translations = Translation::paginate(20);
						break;

					case 2:

						$translations = Translation::where('unstable',1)						
											->paginate(20);

						break;


					case 3:

						$translations = Translation::where('unstable',0)						
											->paginate(20);

						break;
				}
				

			}


			$paginator = $this->GetPaginatorLinks($active_route,$translations->elements());

			$template_vars = [
						'translations' => $translations,
						'editpagelink' => pagelink('translation_edit',$language_id),
						'deletepagelink' => pagelink('translation_delete',$language_id),
						'load_theme' => false,
						'paginator' => $paginator
							];

			LoadView('admin/translations/translations_list.php',$template_vars);
		}

		
/*		public function translations_list($request){ //get paged results
			global $language_id;
			global $parameters;

			$search_value = isset($_REQUEST['search_value'])?$_REQUEST['search_value']:'';
			$page = isset($_REQUEST['page'])?(int)$_REQUEST['page']:1;
			$column_sort = isset($_REQUEST['column_sort'])?$_REQUEST['column_sort']:'';
			$column_sortorder = isset($_REQUEST['column_sortorder'])?$_REQUEST['column_sortorder']:'';

			$columns_sortable = $columns_searchable = [
			'id',
			'reference',
			'type',
			'translation',
			];

			if (!in_array($column_sort, $columns_sortable)) {
				$column_sort = $columns_sortable[0];
			}

			if (!in_array(strtoupper($column_sortorder), ['ASC', 'DESC'])) {
				$column_sortorder = 'ASC';
			}

			//$filter = Dealer::all();

			$filter = Translation::select('*');

			if (strlen(trim($search_value)) > 0) {
				foreach($columns_searchable as $col_teller => $col) {
					if ($col_teller == 0) {
						$operator = 'where';
					} else {
						$operator = 'orwhere';
					}
					$filter = $filter->$operator($col,'LIKE','%'.$search_value.'%');
				}
			}

			$paginator = $filter->paginate(10, ['*'], 'page', $page);
			$filter->orderBy($column_sort, $column_sortorder);
			
			$translations = $filter->get();

			$dt_header = FetchView('admin/dt_header.php', [
				'paginator' => $paginator,
				'load_theme' => false,
			]);

			$template_vars = [
				'translations' => $translations,
				'lbl_edit' => ucfirst(translate('edit')),
				'lbl_delete' => ucfirst(translate('delete')),
				'editpagelink' => pagelink('translation_edit',1),
				'deletepagelink' => pagelink('translation_delete',1),
				'load_theme' => false,
				'search_value' => $search_value,
				'items_per_page' => $this->admin_items_per_page,
				'paginator' => $paginator,
				'dt_header' => $dt_header,
			];

			LoadView('admin/translations/translations_list.php', $template_vars);

		
		}*/
	}

?>