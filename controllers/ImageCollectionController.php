<?php
require('BaseController.php');

class ImageCollectionController extends \App\BaseController {


	private function redirect_collection_overview() {
		global $language_id;
		header('Location:'.pagelink('image_collection',$language_id));	
		exit;
	}

	public function overview() {
		global $html_helper;
		global $site_config;
		global $globals;
		global $active_pagemeta;
		global $language_id;

		$urls = [
			'overview_list_url' => pagelink("image_collection",$language_id,"POST","ImageCollectionController@overview_list")
		];
		$html_helper->addJsVar($urls);
		$html_helper->addScript('<script src="'.$site_config['site_url']->value.'/js/admin_image_collection.js"></script>');

		$url_add = pagelink('image_collection_add',$language_id);

		$template_vars=[
			'url_add' => $url_add,			
		];
		LoadView('admin/image_collection/overview.php', $template_vars);
	}

	public function overview_list($request) {
		global $language_id;
		global $active_route;

		if (isset($_POST['search'])) {
			$search = $_POST['search'];
		} else {
			$search = '';
		}

		if (empty($serach)) {
			$imagecollections = ImageCollection::where('name', 'LIKE', '%'.$search.'%')
			->orderBy('name', 'ASC')->paginate(20);			
		} else {
			$imagecollections = Imagecollection::where('name', 'LIKE', '%'.$search.'%')->paginate(20);
		}

		$paginator = $this->GetPaginatorLinks($active_route,$imagecollections->elements());

		$url_edit = pagelink('image_collection_edit', $language_id, 'GET', 'ImageCollectionController@edit_page');
		$url_delete = pagelink('image_collection_delete', $language_id, 'GET', 'ImageCollectionController@delete_page');
		$url_media_overview = pagelink('image_collection_media_overview', $language_id);


		$template_vars = [
		'imagecollections' => $imagecollections,
		'url_edit' => $url_edit,
		'url_delete' => $url_delete,
		'url_media_overview' => $url_media_overview,
		'load_theme' => false,
		'paginator' => $paginator,
		'lbl_items_found' => self::print_nr_items_found($imagecollections->total(), $language_id)
		];

		LoadView('admin/image_collection/overview_list.php', $template_vars);
	}

	public function add_page() {
		$template_vars = [
			'title' => ucfirst(translate('add')),
			'image_collection' => new ImageCollection(),
			'actionlink' => 'ImageCollectionController@add',
		];

		LoadView('admin/image_collection/form.php', $template_vars);
	}

	public function add($request) {
		global $language_id;

		$image_collection = new ImageCollection();
		$image_collection->fill($request);
		$image_collection->save();

		self::redirect_collection_overview();
	}

	public function edit_page() {
		global $parameters;

		$id_item = isset($parameters[0])?$parameters[0]:0;
		$item = ImageCollection::find($id_item);
		if ($item==null) {
			self::redirect_collection_overview();
		}

		$template_vars = [
			'title' => ucfirst(translate('edit')),
			'image_collection' => $item,
			'actionlink' => 'ImageCollectionController@edit',
		];

		LoadView('admin/image_collection/form.php', $template_vars);
	}

	public function edit($request) {
		global $language_id;
		global $parameters;
				
		$item = ImageCollection::find($request['id']);
		if (!is_null($item)) {
			$item->update($request);			
		}

		self::redirect_collection_overview();
	}

	public function delete_page() {
		global $language_id;
		global $parameters;

		$image_collection_id = isset($parameters[0])?$parameters[0]:0;
		$image_collection_id = (int)$image_collection_id;

		$template_vars = [
			'actionlink' => 'ImageCollectionController@delete',
			'hidden_fields' => [
				'image_collection_id' => $image_collection_id,
			]
		];
		LoadView('modals/delete.php', $template_vars);
	}

	public function delete($request){
		global $language_id;

		if (empty($request['image_collection_id'])) {
			self::redirect_collection_overview();
		}

		$item = ImageCollection::find($request['image_collection_id']);
		if (!is_null($item)) {
			$item->delete();
		}
		self::redirect_collection_overview();
	}

	public function media_overview() {
		global $language_id;
		global $parameters;
		global $globals;

		$image_collection_id = isset($parameters[0])?$parameters[0]:0;
		$image_collection_id = (int)$image_collection_id;

		$image_collection = ImageCollection::find($image_collection_id);
		if (is_null($image_collection)) {
			self::redirect_collection_overview();
		}

		$contents = $image_collection->contents; 

		$url_delete = pagelink('image_collection_media_delete', $language_id, 'GET', 'ImageCollectionController@image_collection_media_delete_page');

		$url_choose = pagelink('image_collection_media_choose', $language_id, 'GET', 'ImageCollectionController@image_collection_media_choose_page').'?image_collection_id='.$image_collection_id;

		$template_vars = [
			'image_collection' => $image_collection,
			'contents' => $contents,
			'url_delete' => $url_delete,
			'url_choose' => $url_choose,
		];

		LoadView('admin/image_collection/media_overview.php', $template_vars);
	}

	public function media_add_page() {
		global $parameters;		
		global $active_pagemeta;

		$image_collection_id = isset($parameters[0])?$parameters[0]:0;
		$image_collection_id = (int)$image_collection_id;

		$image_collection = ImageCollection::find($image_collection_id);

		if (is_null($image_collection)) {
			self::redirect_collection_overview();
		}

		$url_post = actionlink('ImagecollectionController@media_add',$active_pagemeta->id).'?image_collection_id='.$image_collection_id;

		$template_vars = [
			'url_post' => $url_post,
		];

		LoadView('admin/image_collection/media_add_page.php', $template_vars);
	}

	public function media_add() {
		global $language_id;

		if (isset($_REQUEST['image_collection_id'])) {
			$image_collection_id = $_REQUEST['image_collection_id'];
		} else {
			$image_collection_id = 0;
		}

		$image_collection = ImageCollection::find($image_collection_id);

		if (is_null($image_collection)) {
			self::redirect_collection_overview();
		}

		if (!empty($_FILES['file']['size'])) {
			$media = UploadMediaItem($_FILES);

			$imagecollectioncontent = new ImageCollectionContent();
			$imagecollectioncontent->format = 'large';
			$imagecollectioncontent->media_id = $media->id;
			$imagecollectioncontent->image_collection_id = $image_collection->id;
			$imagecollectioncontent->save();
		}

		$url_verder = pagelink('image_collection_media_overview', $language_id, 'GET', 'ImageCollectionController@media_overview');
		$url_verder .= '/'.$image_collection_id;
		header('Location:'.$url_verder);
		exit;
	}

	public function image_collection_media_delete_page() {
		global $language_id;
		global $parameters;

		if (isset($_REQUEST['image_collection_id'])) {
			$image_collection_id = $_REQUEST['image_collection_id'];
		} else {
			$image_collection_id = 0;
		}

		if (isset($_REQUEST['image_collection_content_id'])) {
			$image_collection_content_id = $_REQUEST['image_collection_content_id'];
		} else {
			$image_collection_content_id = 0;
		}

		if (isset($_REQUEST['full_delete'])) {
			$full_delete = (int)$_REQUEST['full_delete'];
		} else {
			$full_delete = 0;			
		}

		$hidden_fields = [
			'image_collection_id' => $image_collection_id,
			'image_collection_content_id' => $image_collection_content_id,
			'full_delete' => $full_delete,
		];

		$template_vars = [
			'actionlink' => 'ImageCollectionController@image_collection_media_delete',
			'hidden_fields' => $hidden_fields,
		];
		LoadView('modals/delete.php', $template_vars);
	}

	public function image_collection_media_delete() {
		global $language_id;

		if (isset($_REQUEST['image_collection_id'])) {
			$image_collection_id = $_REQUEST['image_collection_id'];
		} else {
			$image_collection_id = 0;
		}

		if (isset($_REQUEST['image_collection_content_id'])) {
			$image_collection_content_id = $_REQUEST['image_collection_content_id'];
		} else {
			$image_collection_content_id = 0;
		}

		if (isset($_REQUEST['full_delete'])) {
			$full_delete = (int)$_REQUEST['full_delete'];
		} else {
			$full_delete = 0;			
		}

		$image_collection_content = ImageCollectionContent::find($image_collection_content_id);

		if ($image_collection_content != null) {
			if ($full_delete == 1) {
				if ($image_collection_content->media != null) {
					$image_collection_content->media->full_delete();
				}
			}
			$image_collection_content->delete();			
		}
		
		$url_verder = pagelink('image_collection_media_overview', $language_id, 'GET', 'ImageCollectionController@media_overview');
		$url_verder .= '/'.$image_collection_id;
		header('Location:'.$url_verder);
		exit;
	}

	public function image_collection_media_choose_page() {
		global $active_route;
		global $language_id;

		if (isset($_REQUEST['image_collection_id'])) {
			$image_collection_id = $_REQUEST['image_collection_id'];
		} else {
			$image_collection_id = 0;
		}

		$image_collection = ImageCollection::find($image_collection_id);
		if ($image_collection == null) {
			self::redirect_collection_overview();
		}

		$added_medias_ids = ImageCollectionContent::where('image_collection_id', $image_collection_id)->pluck('media_id')->toArray();

		$media = Media::whereNotIn('id', $added_medias_ids)->orderBy('name', 'ASC')->paginate(20);

		$url_choose = pagelink('image_collection_media_choose', $language_id, 'POST', 'ImageCollectionController@image_collection_media_choose');
		$template_vars = [
			'image_collection' => $image_collection,
			'media' => $media,
			'url_choose' => $url_choose,
		];

		LoadView('admin/image_collection/image_collection_media_choose_page.php', $template_vars);
	}

	public function image_collection_media_choose($request) {
		global $parameters;
		global $language_id;

		if (isset($_REQUEST['image_collection_id'])) {
			$image_collection_id = (int)$_REQUEST['image_collection_id'];
		} else {
			$image_collection_id = 0;
		}

		if (isset($_REQUEST['selected_items'])) {
			$selected_items = $_REQUEST['selected_items'];
		} else {
			$selected_items = [];
		}

		$image_collection = ImageCollection::find($image_collection_id);

		if (is_null($image_collection)) {
			self::redirect_collection_overview();
		}

		if (!empty($selected_items)) {
			foreach($selected_items as $media_id) {
				$imagecollectioncontent = new ImageCollectionContent();
				$imagecollectioncontent->format = 'medium';
				$imagecollectioncontent->media_id = $media_id;
				$imagecollectioncontent->image_collection_id = $image_collection_id;
				$imagecollectioncontent->save();
			}
		}

		$url_verder = pagelink('image_collection_media_overview', $language_id).'/'.$image_collection_id;
		header('Location:'.$url_verder);
		exit;
	}
}