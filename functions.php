<?php
define('TERM',1);
define('TEXT',2);

function rrmdir($dir) {
	foreach(glob($dir . '/*') as $file) {
		if(is_dir($file))
			rrmdir($file);
		else
			unlink($file);
	}
	rmdir($dir);
}

function UploadFileInFolder($folder, $filename, $tmp_path) {
	//upload base dir kan je hier instellen
	$date_parts = explode('/',date('Y/m/d'));
	
	$uploadpath = $folder;
	
	foreach($date_parts as $date_part)
	{
		$uploadpath.="/$date_part";
		
		if(!file_exists($uploadpath)){
			mkdir($uploadpath);
		}
	}
	
	$uploadpath.="/$filename";
	
	if(file_exists($uploadpath)){
		
		$count = 1;
		
		$new_filename = substr($filename,0,strpos($filename,'.')) . "-" . $count . substr($filename,strpos($filename,'.'));
		
		$uploadpath = str_replace($filename,$new_filename,$uploadpath);
		
		while(file_exists($uploadpath)){
			
			$old_filename = $new_filename;
			$count++;
			
			$new_filename = substr($filename,0,strpos($filename,'.')) . "-" . $count . substr($filename,strpos($filename,'.'));
			$uploadpath = str_replace($old_filename,$new_filename,$uploadpath);
		}
		
		$filename = $new_filename;
	}
	
		
	move_uploaded_file($tmp_path,$uploadpath);
	
	return $uploadpath;
}

function UploadFile($filename, $tmp_path){
	return uploadFileInFolder('uploads', $filename, $tmp_path);
}

/*function GetMediaImageData($media_id, $format) {
	global $site_config;
	
	$media = Media::find($media_id);
	
	$b_valid_data = false;
	if($media!=null) {
		$meta = $media->meta()->where('meta_name','image_versions')->first();
	}

	return false;
}*/

function GetMediaImage($media_id, $format){
	global $site_config;
	/*
	returnt img html tag terug van een media item	
	*/
	$image_data = GetMediaImageData($media_id, $format);
	if ($image_data !== false) {
		return '<img src="'.$image_data['image_path'].'" class="img-responsive" width="'.$image_data['image_width'].'" height="'.$image_data['image_height'].'" />';			
	}

	$str_format = '150x150';

	switch($format) {
		case 'original':
			if ($image_data !== false) {
				$str_format = $image_data['image_width'].'x'.$image_data['image_height'];
			}
		case 'thumbnail':
			$str_format = '150x150';
		break;
		case 'small':
			$str_format = '290x290';
		break;
		case 'medium':
			$str_format = '580x580';
		break;
		case 'large':
			$str_format = '1170x1170';
		break;
	}

	return '<img src="http://placehold.it/'.$str_format.'" class="img-responsive" />';
}

function GetMediaImagePath($media_id, $format) {
	$tmp = GetMediaImageData($media_id, $format);
	if (!empty($tmp['image_path'])) {
		return $tmp['image_path'];
	}

	return false;
}

function GetMediaImageData($media_id, $format){
	/*
	returnt meta info terug van een element
	false indien ongeldige data beschikbaar
	*/
	global $site_config;
	
	$media = Media::find($media_id);
	$b_valid_data = false;
	if($media!=null)
	{
		$meta = $media->meta()->where('meta_name','image_versions')->first();
		if (!empty($meta)) {
			$image_versions = json_decode($meta->meta_value,true);

			$keys_image_data = ['image_path', 'image_width', 'image_height'];

			$image_data = [];
			$image_data['image_path'] = isset($image_versions[$format][2])?$image_versions[$format][2]:'';
			$image_data['image_width'] = isset($image_versions[$format][0])?$image_versions[$format][0]:'';
			$image_data['image_height'] = isset($image_versions[$format][1])?$image_versions[$format][1]:'';

			$b_valid_data = true;
			foreach($keys_image_data as $key_image_data) {
				if (strlen(trim($image_data[$key_image_data])) == 0) {
					$b_valid_data = false;
					break;
				}
			}

			if ($b_valid_data) {
				$image_data['image_path'] = $site_config['site_url']->value.$image_data['image_path'];
				return $image_data;
			}
		}
	}

	return false;
}

function LoadModule($module, $parameter='')
{
	global $active_route, $active_page, $active_pagemeta, $active_user, $site_config, $language_id, $parameters,$customcss,$script,$content,$customjs;
	if ($module == 'slider') {
		//slider.php maakt niet meer gebruik van $content variabele
		ob_start();	
		require_once("modules/$module");
		$content = ob_get_clean();
		return $content;
	} else {
		require_once("modules/$module");	
	}
	//die($customjs);
}

function FetchModule($module, $parameter='') {
	ob_start();
	LoadModule($module, $parameter);
	$content = ob_get_clean();
	return $content;
}

function LoadView($viewpath = '',$template_vars=array()){
	global $active_route, $active_page, $active_pagemeta, $active_user, $site_config, $language_id, $parameters, $script,$content,$context,$customjs,$customcss,$meta_tags, $logged_in, $html_helper, $msg_helper, $validator, $globals, $queue;
	//Declare Site
	$site = $site_config['site_url']->value;

	//Get Pagina Info

	///////////////////////HANDLE XTRA CSS & JS
		
	$css = explode(",",$active_page->custom_css);
	$customcss = "";
	foreach($css as $inputcss){
		if($inputcss!=""){
			$customcss .= "<link href='".$site_config['site_url']->value."css/custom/".$inputcss."' rel='stylesheet'>";
		}
	}

	$js = explode(",",$active_page->custom_js);


	foreach($js as $inputjs){
		if($inputjs != ""){
			$customjs .= "<script src='".$site_config['site_url']->value."js/custom/".$inputjs."'></script>";
		}
	}

	$breadcrumb="";
	

	if($viewpath!=""){
		ob_start();
		require_once('views/' . $viewpath);
		$content.= ob_get_clean();
		
	}else{
	
		if($active_pagemeta->view!=null){
			ob_start();
			require_once('views/' . $active_pagemeta->view->location);
			$content.= ob_get_clean();
		}
	}
	if($breadcrumb==""){
		$breadcrumb = generateBreadcrumbs($active_page);
	}


	$script.="$('body').on('hidden.bs.modal', '#modal', function () {
		
		$(this).removeData('bs.modal');
		$('.modal-content').html('');
		
		
	});";
	

	$script = "site='".$site."';language_id='".$language_id."';page='".$active_page->id."';".$script;


	//LOAD THEME
	$theme_basepath = $site_config['site_url']->value . $active_page->theme->location; 
	
	$b_fetch_view = isset($template_vars['fetch_view']) && ($template_vars['fetch_view'] === true)?true:false; //return html ipv echo
	$b_load_theme = (isset($template_vars['load_theme']) && ($template_vars['load_theme'] === false))?false:true;

	if (!$b_load_theme) {
		//als je geen thema wil inladen
		if ($b_fetch_view) {
			if ($viewpath == '../mails/templates/mail_template.php') {
				echo $content;
				die();
			}
			return $content;
		} else {
			echo $content;
			return;
		}		
	} 

	require_once($active_page->theme->location ."/index.php");
}

function FetchView($viewpath = '',$template_vars=array()) {
	//todo: fetchview in elkaar werkt nog niet

	//loadview maar returnt de html ipv echo
	/*if ($viewpath == '../mails/templates/mail_template.php') {
		echo '<pre>';
		print_r($template_vars);
		echo '</pre>';
		die();
	}*/
	$template_vars['fetch_view'] = true;

	return LoadView($viewpath, $template_vars);
}

function FetchTemplate($mail_template, $template_data) {
	ob_start();

	$template_vars = $template_data;
	
	$mail_template = $mail_template;
	require($mail_template);
	$ret = ob_get_clean();
	return $ret;
}

function ParseView($view_content){
	
	global $active_route, $active_page, $active_pagemeta, $active_user, $site_config, $language_id, $parameters;
	
	preg_match_all("/\[\{(.*?)\}\]/",$view_content,$matches);
	
	//
	foreach($matches[1] as $match){
		$match_part = explode(";",$match);
		$module_id = $match_part[0];
		$module_content = $match_part[1];
		
		$module = Module::find($module_id);
		
		$rowcontent = new RowContent;
		$rowcontent->content = $module_content;
		
		$content = "";
		include("modules/" . $module->location);
		
		
		$view_content = str_replace("[{".$match."}]",$content,$view_content);
		
		
	}
	
	
	return $view_content;
}

function CalculatePrice($articleprice,$product_data,&$feature_definitions, &$prices, $totalprice){
	$product_filter=$articleprice->compiled_pt_product_filter;
		
	$price = 0;

	//echo($product_filter . "<br/>");

	//$description = translate('article_price_description_' . $articleprice->id);
	//echo($description ."<br/>");
	if(ParseFormula($product_filter,$product_data,$feature_definitions)==1 || $product_filter==null){
		//echo("valid<hr/>");

		$amount=0;

		$description = translate('article_price_description_' . $articleprice->id);
		//echo($description);
		$sales_unit_price = $articleprice->sales_unit_price;
		$amount_formula = $articleprice->compiled_pt_formula;
		$component_article_reference = ParseFormula($articleprice->compiled_pt_comp_seq_text_expr,$product_data,$feature_definitions);


		$pricetable = $articleprice->pt_prices;
		
		if($sales_unit_price!=null)
		{
			$amount = ParseFormula($amount_formula,$product_data,$feature_definitions);
			$price = $amount * $sales_unit_price;
			
			
		}else if($component_article_reference!=null){
			
			$component_article_reference=str_replace('"','',$component_article_reference);
			$amount = ParseFormula($amount_formula,$product_data,$feature_definitions);
			if($amount_formula=="" || $amount_formula==null) //indien geen amountformule
			{
				$amount=1;
			}

			//echo("amount: $amount reference: $component_article_reference<br/>");
			$component_article = Article::where('reference',$component_article_reference)->first();

			if($component_article!=null)
			{
				if($component_article->sales_unit_price!=null)
				{

					$sales_unit_price = $component_article->sales_unit_price;


				}
				else if($component_article->sales_unit_price_incl_vat!=null)
				{
					$sales_unit_price = $component_article->sales_unit_price_incl_vat/1.21;
				}
				else
				{
					$sales_unit_price = 0;
				}

				$price = $amount * $sales_unit_price;
				
				
				
			}
			
		}else if($pricetable!=null){

			$amount = ParseFormula($amount_formula,$product_data,$feature_definitions);

			if($amount_formula=="" || $amount_formula==null) //indien geen amountformule
			{
				$amount=1;
			}
			
			$pricetable = explode("|",preg_replace("/[\n\r]/","|",$pricetable));
			
			for($i=0; $i<count($pricetable); $i++){
				$pricetable[$i]=explode(";",$pricetable[$i]);
			}	
			
			
			$width_start = $articleprice->pt_width_start;
			$width_end = $articleprice->pt_width_end;
			$width_step = $articleprice->pt_width_step;
			$width_values = $articleprice->pt_width_values;
			$length_start = $articleprice->pt_length_start;
			$length_end = $articleprice->pt_length_end;
			$length_step = $articleprice->pt_length_step;
			$length_values = $articleprice->pt_length_values;
			
			
			$length_formula=$articleprice->compiled_pt_length_formula;
			$width_formula=$articleprice->compiled_pt_width_formula;


			
			$length = ParseFormula($length_formula,$product_data,$feature_definitions);
			$width = ParseFormula($width_formula,$product_data,$feature_definitions);
			//echo("Length: $length - Width: $width");
			$lengthindex = ceil(($length-$length_start)/$length_step);
			if($lengthindex<0)
			{
				$lengthindex=0;
			}
			$widthindex = ceil(($width-$width_start)/$width_step);
			if($widthindex<0)
			{
				$widthindex=0;
			}
			//echo("Length: $lengthindex - Width: $widthindex");
			if(isset($pricetable[$widthindex][$lengthindex])){
			
				$price=$amount*$pricetable[$widthindex][$lengthindex];
			
				
				
			}
			
		}

		if($articleprice->discount_percentage!=null)
		{
			if($price==0)
			{
				$price = $totalprice * ($articleprice->discount_percentage/100) * -1;

			}else{
				$price-=$price*($articleprice->discount_percentage/100);
			}

		}

		if($articleprice->surcharge_percentage!=null)
		{
			if($price==0)
			{
				$price = $totalprice * ($articleprice->surcharge_percentage/100);

			}else{
				$price+=$price*($articleprice->surcharge_percentage/100);
			}


		}
		
		
		if($articleprice->fin_vat_code_id!=null)
		{
			switch($articleprice->fin_vat_code_id)
			{
				case 1: //verkoop 21%
					$price=$price/1.21;
					break;
				case 2: //medecontractant
					$price=$price;
					break;
				case 3: //verkoop 6%
					$price=$price/1.06;
					break;
				case 4: //export 0%
					$price=$price;
					break;
			}
		}

		if($price!=0){

			array_push($prices,array($amount,$description,$price,$articleprice->id,0));	
		}
		
	}
		
	return $price;
}

function CalculateArticlePrice($article_id,$product_data,&$feature_definitions){
	
	$totalprice = 0;
	
	$prices = array();
	
	$article = Article::find($article_id);

	if($article!=null){

	$basicprices = $article->prices()->where('pt_basic_price',1)->orderBy('processing_order')->get();
	
	foreach($basicprices as $basicprice){
		
		$totalprice = CalculatePrice($basicprice,$product_data,$feature_definitions,$prices,$totalprice);
		
		if($totalprice>0)
		{
			break;
		}
	}


	
	$additionalprices = $article->prices()->whereNull('pt_basic_price')->orderBy('processing_order')->get(); //if basic_price is not set
	$additionalprices2 = $article->prices()->where('pt_basic_price',0)->orderBy('processing_order')->get(); //if basic_price is 0
	
	$additionalprices =$additionalprices->merge($additionalprices2);


	
	foreach($additionalprices as $additionalprice)
	{

		$totalprice+=CalculatePrice($additionalprice,$product_data,$feature_definitions,$prices,$totalprice);
	}	
	
	
	$result = array();
	
	$result['prices']=$prices;
	$result['totalprice']=round($totalprice,2);

	return json_encode($result);

	}
}

function Paginate($table_id,$pagelink,$datacolumns, $data=''){
	global $site_config,$language_id;
	$result = "$('#$table_id').DataTable( {";
	$result.="'ajax' : {
			'url': '" . $pagelink ."',
			'method': 'POST',
            'data': { $data }
		},
		'language': {
			processing: '" . e(ucfirst(translate("processing"))) . "',
			search: '" . e(ucfirst(translate("find"))) . "',
			lengthMenu: '" . e(ucfirst(translate("lengthMenu"))) . "',
			info: '" . e(ucfirst(translate("info"))) . "',
			infoEmpty: '" . e(ucfirst(translate("infoEmpty"))). "',
			infoFiltered: '" . e(ucfirst(translate("infoFiltered"))) . "',
			infoPostFix: '" . e(ucfirst(translate("infoPostFix"))) . "',
			loadingRecords: '" . e(ucfirst(translate("loadingRecords"))) . "',
			zeroRecords: '" . e(ucfirst(translate("zeroRecords"))) . "',
			emptyTable: '" . e(ucfirst(translate("emptyTable"))) . "',
			paginate: {
				first: '" . e(ucfirst(translate("first"))) . "',
				previous: '" . e(ucfirst(translate("previous"))) . "',
				next: '" . e(ucfirst(translate("next"))) . "',
				last: '" . e(ucfirst(translate("last"))) . "'
			},aria: {
				sortAscending: '" . e(ucfirst(translate("sortAscending"))) . "',
				sortDescending: '" . e(ucfirst(translate("sortDescending"))) . "'
			}
			
		},
		'order': [[0,'desc']],
		'processing': true, 'serverSide': true,
		'columns': [";
		
	$result.=$datacolumns;	
           
        
	$result.="]} );";
	
	return $result;
}

function BuildFeatureDefinitions($product){
	$result = array();
	$names=array();
	$codes=array();
	$types=array();
	
	$features = $product->features;
	foreach($features as $feature)
	{		
		$name=$feature->name;
		$code=$feature->code;
		$type=$feature->product_feature_type;
		
		$names[$name]=$feature->id;
		$codes[$code]=$feature->id;
		$types[$feature->id]=$type;
	}
	
	
	$result[0]=$names;
	$result[1]=$codes;
	$result[2]=$types;
	
	return $result;
	
}

function ReplaceSimpleFunction(&$filter,$vision_function,$php_function)
{
	$function_found =(strpos($filter,$vision_function));
	if($function_found!==false)
	{
		//echo("[$vision_function] gevonden<br/>");
		
		$filter=str_replace($vision_function,$php_function,$filter);
	}

	if(strpos($filter,$vision_function)>0){
		die("Er zijn nog $vision_function aanwezig in de filter");
	}
}

function ReplaceMinMaxFunction(&$filter,$vision_function,$php_function)
{
	$function_found =(strpos($filter,$vision_function));
	if($function_found!==false)
	{
		//echo("[$vision_function] gevonden<br/>");
		
			$last_position = 0;

			$last_position = strpos($filter,$vision_function,$last_position);

			$filter_array=str_split($filter);

			$replacements = array();

			while($last_position!==false){

				
				$open_bracket_count=0;
				$close_bracket_count=0;
				$start_content_position = 0;
				$stop_content_position = 0;

				for($i=$last_position; $i<count($filter_array);$i++)
				{
					
					
					if($filter_array[$i]=="("){
						$open_bracket_count++;
						
						if($open_bracket_count==1)
						{
							$start_content_position=$i;
							
						}
					}else if($filter_array[$i]==")"){
						$close_bracket_count++;
						
						if($open_bracket_count==$close_bracket_count && $open_bracket_count>0)
						{
							$stop_content_position=$i;
							
							break;
						}
					}


					
				}


				if($stop_content_position>$start_content_position && $stop_content_position!=0)
				{
					$content = substr($filter,$start_content_position+1,($stop_content_position-$start_content_position-1));
					//echo($content . "<br>");
					
					$last_position=$stop_content_position+1;
					
					$content_parts = explode(';',$content);
					//var_dump($content_parts);
					
					$content="$vision_function($content)";
					
					//echo("content: $content<br/>");
					
					$replacement_content = "$php_function(";
					
					for($j=0; $j<count($content_parts); $j++){
						
						$replacement_content.= $content_parts[$j] . ",";
						
					}
					if(count($content_parts)>0)
					{
						$replacement_content=substr($replacement_content,0,strlen($replacement_content)-1);
					}
					$replacement_content.=")";
					
					//echo("replacement_content: $replacement_content<br/>");
					
					$replacements[$content]=$replacement_content;
					
				}
				
				
				
				$last_position = strpos($filter,$vision_function,$last_position);

			}

			while(list($content,$replacement_content)=each($replacements)){
				
				//echo("content: $content<br/>");
				//echo("replacement_content: $replacement_content<br/>");
				$filter = str_replace($content,$replacement_content,$filter);
				
			}
		//$filter=str_replace($vision_function,$php_function,$filter);
	}

	if(strpos($filter,$vision_function)>0){
		die("Er zijn nog $vision_function aanwezig in de filter");
	}
}

function ReplaceInlist(&$filter){

	$last_position = 0;

	$last_position = strpos($filter,'@inlist',$last_position);

	$filter_array=str_split($filter);

	$replacements = array();


	while($last_position!==false){

		//echo('@inlist gevonden op positie ' . $last_position . "<br/>");

		$open_bracket_count=0;
		$close_bracket_count=0;
		$start_content_position = 0;
		$stop_content_position = 0;

		for($i=$last_position; $i<count($filter_array);$i++)
		{
			
			//echo($filter_array[$i] . "<br/>");
			if($filter_array[$i]=="("){
				$open_bracket_count++;
				
				if($open_bracket_count==1)
				{
					$start_content_position=$i;
					//echo('start positie: ' . $start_content_position . "<br/>");
				}
			}else if($filter_array[$i]==")"){
				$close_bracket_count++;
				
				if($open_bracket_count==$close_bracket_count && $open_bracket_count>0)
				{
					$stop_content_position=$i;
					
					break;
				}
			}

			

			
		}


		if($stop_content_position>$start_content_position && $stop_content_position!=0)
		{
			$content = substr($filter,$start_content_position+1,($stop_content_position-$start_content_position-1));
			//echo($content . "<br>");
			
			$last_position=$stop_content_position+1;
			
			$content_parts = explode(';',$content);
			//var_dump($content_parts);
			
			$content="@inlist($content)";
			
			//echo("content: $content<br/>");
			
			$replacement_content = "in_array(" . $content_parts[0] . ",array(";
			
			for($j=1; $j<count($content_parts); $j++){
				
				$replacement_content.= $content_parts[$j] . ",";
				
			}
			if(count($content_parts)>1)
			{
				$replacement_content=substr($replacement_content,0,strlen($replacement_content)-1);
			}
			$replacement_content.="))";
			
			//echo("replacement_content: $replacement_content<br/>");
			
			$replacements[$content]=$replacement_content;
			
		}
		
		
		
		$last_position = strpos($filter,'@inlist',$last_position);

	}

	while(list($content,$replacement_content)=each($replacements)){
		
		//echo("content: $content<br/>");
		//echo("replacement_content: $replacement_content<br/>");
		$filter = str_replace($content,$replacement_content,$filter);
		
	}
	$vision_function="@inlist";

	if(strpos($filter,$vision_function)>0){
		die("Er zijn nog $vision_function aanwezig in de filter");
	}
	
}



function ReplaceLeftFunction(&$filter)
{
	$vision_function="@left";
	
	$function_found =(strpos($filter,$vision_function));
	if($function_found!==false)
	{
		//echo("[$vision_function] gevonden<br/>");
		
			$last_position = 0;

			$last_position = strpos($filter,$vision_function,$last_position);

			$filter_array=str_split($filter);

			$replacements = array();

			while($last_position!==false){

				
				$open_bracket_count=0;
				$close_bracket_count=0;
				$start_content_position = 0;
				$stop_content_position = 0;

				for($i=$last_position; $i<count($filter_array);$i++)
				{
					
					
					if($filter_array[$i]=="("){
						$open_bracket_count++;
						
						if($open_bracket_count==1)
						{
							$start_content_position=$i;
							
						}
					}else if($filter_array[$i]==")"){
						$close_bracket_count++;
						
						if($open_bracket_count==$close_bracket_count && $open_bracket_count>0)
						{
							$stop_content_position=$i;
							
							break;
						}
					}


					
				}


				if($stop_content_position>$start_content_position && $stop_content_position!=0)
				{
					$content = substr($filter,$start_content_position+1,($stop_content_position-$start_content_position-1));
					//echo($content . "<br>");
					
					$last_position=$stop_content_position+1;
					
					$content_parts = explode(';',$content);
					//var_dump($content_parts);
					
					$content="$vision_function($content)";
					
					//echo("content: $content<br/>");
					
					$replacement_content = "substr(" . $content_parts[0] . ",0,";
									
					$replacement_content.= $content_parts[1] . ")";
								
					//echo("replacement_content: $replacement_content<br/>");
					
					$replacements[$content]=$replacement_content;
					
				}
				
				
				
				$last_position = strpos($filter,$vision_function,$last_position);

			}

			while(list($content,$replacement_content)=each($replacements)){
				
				//echo("content: $content<br/>");
				//echo("replacement_content: $replacement_content<br/>");
				$filter = str_replace($content,$replacement_content,$filter);
				
			}
		//$filter=str_replace($vision_function,$php_function,$filter);
	}

	if(strpos($filter,$vision_function)>0){
		die("Er zijn nog $vision_function aanwezig in de filter");
	}
}

function ReplaceRightFunction(&$filter)
{
	$vision_function="@right";
	
	$function_found =(strpos($filter,$vision_function));
	if($function_found!==false)
	{
		//echo("[$vision_function] gevonden<br/>");
		
			$last_position = 0;

			$last_position = strpos($filter,$vision_function,$last_position);

			$filter_array=str_split($filter);

			$replacements = array();

			while($last_position!==false){

				
				$open_bracket_count=0;
				$close_bracket_count=0;
				$start_content_position = 0;
				$stop_content_position = 0;

				for($i=$last_position; $i<count($filter_array);$i++)
				{
					
					
					if($filter_array[$i]=="("){
						$open_bracket_count++;
						
						if($open_bracket_count==1)
						{
							$start_content_position=$i;
							
						}
					}else if($filter_array[$i]==")"){
						$close_bracket_count++;
						
						if($open_bracket_count==$close_bracket_count && $open_bracket_count>0)
						{
							$stop_content_position=$i;
							
							break;
						}
					}


					
				}


				if($stop_content_position>$start_content_position && $stop_content_position!=0)
				{
					$content = substr($filter,$start_content_position+1,($stop_content_position-$start_content_position-1));
					//echo($content . "<br>");
					
					$last_position=$stop_content_position+1;
					
					$content_parts = explode(';',$content);
					//var_dump($content_parts);
					
					$content="$vision_function($content)";
					
					//echo("content: $content<br/>");
					
					$replacement_content = "substr(" . $content_parts[0] . ",-";
									
					$replacement_content.= $content_parts[1] . ")";
								
					//echo("replacement_content: $replacement_content<br/>");
					
					$replacements[$content]=$replacement_content;
					
				}
				
				
				
				$last_position = strpos($filter,$vision_function,$last_position);

			}

			while(list($content,$replacement_content)=each($replacements)){
				
				//echo("content: $content<br/>");
				//echo("replacement_content: $replacement_content<br/>");
				$filter = str_replace($content,$replacement_content,$filter);
				
			}
		//$filter=str_replace($vision_function,$php_function,$filter);
	}

	if(strpos($filter,$vision_function)>0){
		die("Er zijn nog $vision_function aanwezig in de filter");
	}
}

function CompileFormula($filter,$feature_definitions)
{

	$matches = array();

	$expressions=array();
	
	//eerste deel geeft aan welke tabel moet gekozen worden in de feature_definitions (0=omschrijving, 1=code)
	//tweede deel geeft aan welke waarde moete gekozen worden in de form_data (0=code,1=omschrijving)
	
	$expressions["/dfd\(\"(.*?)\"\)/"]='0|0';
	$expressions["/dfc\(\"(.*?)\"\)/"]='1|0';
	$expressions["/cfd\(\"(.*?)\"\)/"]='0|1';
	$expressions["/cfc\(\"(.*?)\"\)/"]='1|1';
	$expressions["/fd\(\"(.*?)\"\)/"]='0|1';
	$expressions["/fc\(\"(.*?)\"\)/"]='1|1'; 

	while(list($expression,$parameter)=each($expressions))
	{

		preg_match_all($expression,$filter,$matches);

		$match_sections=$matches[0];
		$match_values=$matches[1];

		
		for($i=0; $i<count($match_values); $i++){

			//lookup feature_id

			$match_value=$match_values[$i];
			//echo("Match value: " . $match_value . "- " . $match_sections[$i] . "<br/>");

			$parameters=explode("|",$parameter);

			switch($parameters[0]) //wat staat er tussen haakjes? (description of number)
			{
				case 0: //description
					if(isset($feature_definitions[0][$match_value])){ //if the feature exists
						$feature_id = $feature_definitions[$parameters[0]][$match_value];

						
					}else{
						$feature_id=0;

						var_dump($feature_definitions);
					}

					

					break;
				case 1: //number

					if(isset($feature_definitions[1][$match_value])){ //if the feature exists
						$feature_id = $feature_definitions[$parameters[1]][$match_value];

					
					}else{
						$feature_id=0;

						var_dump($feature_definitions);
					}

					

					break;
			}
			
			switch($parameters[1]) //wat moet er komen?
			{
				case 1: //number

					$filter = str_replace($match_sections[$i],"number[" . $feature_id. "]",$filter);
					
					break;

				case 0: //description

					$filter = str_replace($match_sections[$i],"description[" . $feature_id. "]",$filter);
					
					break;
			}
		}

	}
	//echo("<h1>inlist</h1>");
	
	ReplaceInlist($filter);

	ReplaceLeftFunction($filter);
	ReplaceRightFunction($filter);
	

	
	$functions = [
	"@min" => "min",
	"@max" => "max"
	];

	while(list($vision_function,$php_function) = each($functions)){
		ReplaceMinMaxFunction($filter,$vision_function,$php_function);
	}


	$functions = [
		"@ceil" => "ceil",
		"@floor" => "floor",
		"@round" => "round",
		"@sqrt" => "sqrt",
		"@sin" => "sin",
		"@cos" => "cos",
		"@tan" => "tan",
		"@asin" => "asin",
		"@acos" => "acos",
		"@atan" => "atan",
		"@rtod" => "rad2deg"	
		];

	while(list($vision_function,$php_function) = each($functions)){
		ReplaceSimpleFunction($filter,$vision_function,$php_function);
	}


	
	return $filter;
}


function ParseFormula($filter,&$form_data,$feature_definitions){
	

	$expressions=array();
	
	
	$expressions["/number\[(.*?)\]/"]=0;
	$expressions["/description\[(.*?)\]/"]=1;

	$evaluate_filter=1;

	//echo($filter . "<hr/>");//file_put_contents('filters.txt', $filter . "\n", FILE_APPEND | LOCK_EX);
	
	while(list($expression,$parameter)=each($expressions)){
		
		$matches = array();
		preg_match_all($expression,$filter,$matches);
		
		$features = $matches[0];
		$feature_ids = $matches[1];
		
		$feature_types=$feature_definitions[2];
		
		for($i=0; $i<count($features); $i++){
			
			$feature = $features[$i];

			$feature_id = $feature_ids[$i];

			//echo("feature_id :" . $feature_id . "\n");
			$feature_type = $feature_definitions[2][$feature_id];

			$feature_values = explode('|',$form_data['feature_' . $feature_id]);
			
			$form_value = $form_data['feature_' . $feature_id];

			switch($feature_type){
				
				case 1:
					
					if("$form_value"!=""){
						//echo($filter);
						$feature_value=''.$feature_values[$parameter].'';
					}else{
						//don't evaluate
						$evaluate_filter=0;
						$feature_value=0;
						
						//file_put_contents('filters.txt', 'ik heb geen waarde voor ' . $feature_id . "\n", FILE_APPEND | LOCK_EX);
						//file_put_contents('filters.txt', json_encode($form_data) . "\n", FILE_APPEND | LOCK_EX);
					}
				
					break;
				
				case 2:
				
					if("$form_value"!=""){
						$feature_value='"'.$feature_values[$parameter].'"';
					}else{
						//don't evaluate
						$evaluate_filter=0;
						$feature_value="\"\"";
					
						
						//file_put_contents('filters.txt', 'ik heb geen waarde voor ' . $feature_id . "\n", FILE_APPEND | LOCK_EX);
						
					}
				
					break;
			}
			
			
			$filter=str_replace($feature,$feature_value,$filter);
			
			
			
		}
	}

	//echo($filter . "\n");

	
	
	if($evaluate_filter==1){
	
		//echo($filter."<hr/>");

		//file_put_contents('filters.txt', "$filter\n", FILE_APPEND | LOCK_EX);

		$result = eval("return $filter;");
	
		
	}else{
		$result = "";
	}

	
	return $result;
	
}

function HideFeature($feature_id, &$form_data,&$hidden_features)
{
	if(!in_array($feature_id, $hidden_features))
	{
		//echo('ik hide ' . $feature_id);
		if($form_data["hide_feature"]==""){
			$form_data["hide_feature"]=$feature_id;
		}else{
			$form_data["hide_feature"].=";" . $feature_id;
		}
	}
}

function ShowFeature($feature_id, &$form_data,&$hidden_features)
{
	if(in_array($feature_id, $hidden_features))
	{
		if($form_data["show_feature"]==""){
			$form_data["show_feature"]=$feature_id;
		}else{
			$form_data["show_feature"].=";" . $feature_id;
		}
	}
}



function EvaluateFeature($configurator_feature,&$form_data,&$feature_definitions){
	
	
	$feature=$configurator_feature->feature;
	$feature_id = $feature->id;

	//echo("evaluation started " . $feature_id . "\n");
	//echo($configurator_feature->options()->with('productoption')->toSql());
	//$options = $configurator_feature->options()->with('productoption'->orderBy('hides_feature','desc')->get();

	$options = ConfiguratorProductOption::select('configurator_product_option.*','product_option.*')
		->join('product_option','configurator_product_option.product_option_id','=','product_option.id')
		->where('configurator_product_option.configurator_product_feature_id',$configurator_feature->id)
		->where(function($query){
			$query->where('product_option.order_entry_blocked','<>','1');
			$query->orWhereNull('product_option.order_entry_blocked');
		})
		->where(function($query){
			$query->where('product_option.no_order_entry','<>','1');
			$query->orWhereNull('product_option.no_order_entry');
		})
		->orderBy('configurator_product_option.hides_feature','DESC')
		->orderBy('product_option.presentation_order')
		->get();



	$valid_options=array();
	$show_feature = array();
	$hide_feature = array();
	$hidden_features = explode(';',$form_data['hidden_features']);
	$enable_feature = array();
	$disable_feature = array();

		
		if($feature->product_feature_type==1){ //indien getal
			
			$hide_now=0;

			foreach($options as $option){


		
				//$product_option = $option->productoption;
				$product_option = $option;

				$hides_feature = $option->hides_feature;

				$minimum_formula=$product_option->compiled_minimum_formula;
				
				if($minimum_formula!=null){
					$minimum=ParseFormula($minimum_formula,$form_data,$feature_definitions);
				}else{
					$minimum=0;
				}
				
				$maximum_formula=$product_option->compiled_maximum_formula;
				
				if($maximum_formula!=null){
					$maximum=ParseFormula($maximum_formula,$form_data,$feature_definitions);
				}else{
					$maximum=999999;
				}
				
				
				$option_formula=$product_option->compiled_option_formula;
				$option_default=$product_option->compiled_option_default;
				$option_filter=$product_option->compiled_option_filter;
				$option_filter_not=$product_option->compiled_option_filter_not;
				
				$option_valid = 0;
				
				if($option_filter!=null){
					
					if(ParseFormula($option_filter,$form_data,$feature_definitions) == 1){
						$filter_valid = 1;
						
					}else{
						$filter_valid = 0;
					}
				}
				else
				{
					$filter_valid = 1;
				}
				
				if($option_filter_not!=null)
				{
					if(ParseFormula("!(" . $option_filter_not . ")",$form_data,$feature_definitions) == 1){
						$filter_not_valid = 1;
					}else{
						$filter_not_valid = 0;
					}
				}else{
					$filter_not_valid = 1;
				}
				
				$option_valid = $filter_valid && $filter_not_valid;

				//file_put_contents('filters.txt', $option->product_option_id . "\n", FILE_APPEND | LOCK_EX);
			
				if($option_valid == 1){
	
					$feature_value=$form_data['feature_' . $feature_id];
		
										
					if($option_formula!=null){
						
						if($configurator_feature->feature_entry_allowed==1)
						{
							$formula_value=ParseFormula($option_formula,$form_data,$feature_definitions);

							if("$feature_value"=="")
							{
								
								$form_data['feature_' . $feature_id]=$formula_value;
								$feature_value=$formula_value;
							}
						}else{ //always execute formula
							$formula_value=ParseFormula($option_formula,$form_data,$feature_definitions);
							$form_data['feature_' . $feature_id]=$formula_value;
							$feature_value=$formula_value;
						}

	

					}else{
						$formula_value="";
					}
					
					$form_data["min_" . $feature_id]=$minimum;
					$form_data["max_" . $feature_id]=$maximum;
					

					
					if("$formula_value"!="" && ("$minimum" == "$maximum") && ("$maximum" == "$formula_value"))
					{

						if($formula_value!=$feature_value)
						{
							$form_data['feature_' . $feature_id]=$formula_value;
						}

						/*if($formula_value==0){
							
							HideFeature($feature_id,$form_data,$hidden_features);
						}*/

						
					}else{
						if($configurator_feature->feature_entry_visible==1){

							ShowFeature($feature_id,$form_data,$hidden_features);
						}
					}
				

			

					array_push($valid_options,$product_option);

					if($hides_feature!=null && $hides_feature==1)
					{
						$hide_now=1;
						break; //spring uit lus aangezien het niet meer verder moet geevalueerd worden
					}else{
						$hide_now=0;
					}
				
				}
			}


			if($hide_now==1)
			{
				HideFeature($feature_id,$form_data,$hidden_features);
			}else{
				ShowFeature($feature_id,$form_data,$hidden_features);
			}

				
			
		}else{ //indien tekst
			
			$hide_now=0;
			$option_list = "";

			$show_custom_feature=0;

			foreach($options as $option){

				$hides_feature = $option->hides_feature;
				
				//$product_option = $option->productoption;
				$product_option = $option;

				$option_filter=$product_option->compiled_option_filter;
				$option_filter_not=$product_option->compiled_option_filter_not;
				$option_default=$product_option->compiled_option_default;


				$option_valid = 0;

									
				if($option_filter!=null){
					if(ParseFormula($option_filter,$form_data,$feature_definitions) == 1){
							
					
						$filter_valid = 1;
					}else{
						$filter_valid = 0;
					}	
				}
				else
				{
					$filter_valid = 1;
				}

				
				if($option_filter_not!=null){
					if(ParseFormula("!(" . $option_filter_not . ")",$form_data,$feature_definitions) == 1){
							
						$filter_not_valid = 1;					
					}else{
						$filter_not_valid = 0;
					}
				}else
				{
					$filter_not_valid = 1;
				}

				$option_valid = $filter_valid && $filter_not_valid;

				if($option_valid){

					
					$product_option_id = $product_option->id;

					if($option_list==""){
						$option_list="$product_option_id";
					}else{
						$option_list.=";" . $product_option->id;
					}


					
					/*if($form_data["option_$feature_id"]==""){
						$form_data["option_$feature_id"]=$product_option->id;
					}else{
						$form_data["option_$feature_id"].=";" . $product_option->id;
					}
					*/
					

					if($option_default!=null)
					{
						if(ParseFormula($option_default,$form_data,$feature_definitions) == 1){

							if($form_data['feature_' . $feature_id]=="")
							{
								$form_data['feature_' . $feature_id]=$product_option->code.'|'.$product_option->name;

								if(ProductOptionMessage::where('product_option_id',$option->product_option_id)->count()>0){


									if($form_data['showmessages']==""){
										$form_data['showmessages']="$feature_id";
									}else{
										$form_data['showmessages'].=";" . $feature_id;
									}

								}

							}	
						}
					}

					if($product_option->name_editable==1)
					{
						$show_custom_feature=1;
					}

									

					array_push($valid_options,$product_option);

					if($hides_feature!=null && $hides_feature==1)
					{
						$hide_now=1;
						break; //spring uit lus aangezien het niet meer verder moet geevalueerd worden
					}else{
						$hide_now=0;
						
					}

					
				}
			
			}

			if(count($valid_options)==1){
						
				$form_data['feature_' . $feature_id]=$valid_options[0]->code.'|'.$valid_options[0]->name;		 
					
			}

			if($show_custom_feature==1)
			{
				//kijken bij welke optie nu custom field moet weergegeven worden

				foreach($valid_options as $valid_option)
				{
					if($valid_option->name_editable==1)
					{
						if($form_data['feature_' . $feature_id]!="")
						{
						
							$parts = explode('|',$form_data['feature_' . $feature_id]);


							if($parts[0]==$valid_option->code)
							{
								ShowFeature("customfeature_$feature_id",$form_data,$hidden_features);
							}else{
								HideFeature("customfeature_$feature_id",$form_data,$hidden_features);
							}

						}			
							
					}
				}
			
			}
			

			if($hide_now==1)
			{
				HideFeature($feature_id,$form_data,$hidden_features);
			}else{
				ShowFeature($feature_id,$form_data,$hidden_features);
			}


			


			if($option_list!=$form_data["option_$feature_id"])
			{
				$form_data["option_$feature_id"]=$option_list;
			}
			

		
	}

	//echo("evaluation finished " . $feature_id. "<br/>");
	
	return $valid_options;
}

function YesNo($input){
	if($input==1){
		return translate('yes');
	}else{
		return translate('no');
	}
}

function extractOptionalParameters($path)
{
	preg_match_all('/{(\w+?)}/', $path, $matches);

	return $matches[1];
}

function ExecuteMigration($migration){
	require_once("migrations/" . $migration . ".php");
	
	$class = $migration . 'Migration';
	
	$obj = new $class;
	
	$obj->up();
}

function RollbackMigration($migration){
	require_once("migrations/" . $migration . ".php");
	
	$class = $migration . 'Migration';
	
	$obj = new $class;
	
	$obj->down();
}


function pagelink($reference, $language_id, $method='GET', $controller_function=null, $parameters = array()){
	global $site_config;
	$link="";
	$page = Page::where('reference',$reference)->where('active',1)->first();
	if($page!=null){
		$pagemeta = $page->pagemetas->where('language_id',$language_id)->first();
		if($pagemeta!=null){
			if($controller_function!=null)
			{
				$route = $pagemeta->routes->where('method',$method)->where("controller_function",$controller_function)->first();
			}else{
				$route = $pagemeta->routes->where('method',$method)->first();
			}
			

			if (!is_null($route)) {
				if(!empty($parameters)){
					$link=$route->uri;
					preg_match_all('/\/{\w+}/',$route->uri,$matches);
					
					$count = 0;
					
					
					foreach($matches as $match){
						
						foreach($match as $m)
						{
							if(isset($parameters[$count])){
								$link = str_replace($m,"/" . $parameters[$count],$link);
							}else{
								$link = str_replace($m,"",$link);
							}
						$count++;
						
						}
					}
				}else{
					$link=preg_replace('/\/{\w+}/','',$route->uri);
				}	
			}
		}else{
			$link = "";
		}
		
		$link=$site_config['site_url']->value . $link; 
	}
	
	return $link;
}

function actionlink($action,$page_meta_id = 0){
	global $site_config;
	if($page_meta_id!=0){
		$route =  Route::where('controller_function',$action)->where('page_meta_id',$page_meta_id)->first();
	}else{
		$route = Route::where('controller_function',$action)->first();
	}
	$link="";
	if($route!=null){
		$link=preg_replace('/\/{\w+}/','',$route->uri);
		$link=$site_config['site_url']->value . $link; 
		
	}
	return $link;
	
}

function translate($reference,$type = 1, $lang_id = 0){
	
	//translation type 1 = term
	//translation type 2 = text
	
	global $language_id,$active_user,$site_config;

	if (empty($lang_id)) {
		$lang_id = $language_id;
	}
	
	
	$translated_term = Translation::where('reference',$reference)->where('language_id',$lang_id)->where('type',$type)->first();

	if($translated_term!=null){
		if(isLoggedIn() && ($site_config['inline_translations_active']->value == 1) && $active_user->can('edit_translations_inline')){			
			$ret_val = $translated_term->translation .  " <a data-toggle='modal' data-target='#modal' href='" . pagelink('translation_edit',$lang_id) . '/' . $translated_term->id . "'>Edit</a>";
		}else{
			$ret_val = $translated_term->translation;
		}

		//return nl2br($ret_val);		
		return $ret_val;		
	}else{
		$languages = Language::where('active',1)->get();
		
		foreach($languages as $language)
		{
			$translated_term = new Translation();
			$translated_term->reference = $reference;
			$translated_term->language_id = $language->id;
			$translated_term->translation = $reference;
			$translated_term->unstable = 1;
			$translated_term->type = $type;
			try {
				$translated_term->save();	
			} catch(Exception $ex) {
				
			}
			
		}					
		return '!--' . $reference . '--!';
	}
}


function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}



function buildMenu($parent_id){
	
	$result = "";
	
	global $language_id;
	$pages = Page::where('parent_id',$parent_id)->get();
	
	foreach($pages as $page){
		
		$pagemeta = $page->pagemetas->where('language_id',$language_id)->first();
		
		if($pagemeta!=null){
			

			if(Page::where('parent_id',$page->id)->count()>0){
				$result.=("<li><a href='javascript:;' data-toggle='collapse' data-target='#menu_".$page->id."'>" . $pagemeta->title . "<b class='caret' style='color:#333;'></b></a>");
				$result.=("<ul id='menu_".$page->id."' class='collapse'>");
				$result.=buildMenu($page->id);
				$result.=("</ul></li>");
			}else{
				$result.=("<li><a href='" . pagelink($page->reference,$language_id) . "'>" . $pagemeta->title . "</a></li>");
			}
			
		}
		
	}
	
	return $result;
}



function mkdirs($dir, $mode = 0777, $recursive = true) {
  if( is_null($dir) || $dir === "" ){
    return FALSE;
  }
  if( is_dir($dir) || $dir === "/" ){
    return TRUE;
  }
  if( mkdirs(dirname($dir), $mode, $recursive) ){
    return mkdir($dir, $mode);
  }
  return FALSE;
}

function generateBreadcrumbs($active_page){
	
	global $language_id;
	

	$active_pagemeta = $active_page->pagemetas()->where('language_id',$language_id)->first();

	$result="";
	
	if($active_page->reference=='home')
	{
		$result.= "<li><a href='" . pagelink($active_page->reference,$language_id) . "'><span class='glyphicon glyphicon-home'></span></a></li>". $result;
	}
	
	$result.= "<li class='active'><a href='" . pagelink($active_page->reference,$language_id) . "'>" . $active_pagemeta->name ."</a></li>";
	
	
	
	$parent_page=Page::find($active_page->parent_id);
	
	while($parent_page!=null){
		
		$active_pagemeta = $parent_page->pagemetas()->where('language_id',$language_id)->first();
		if($parent_page->reference=='home'){
			$result = "<li><a href='" . pagelink($parent_page->reference,$language_id) . "'><span class='glyphicon glyphicon-home'></span></a></li>". $result;
		}else{

			$result = "<li><a href='" . pagelink($parent_page->reference,$language_id) . "'>" . $active_pagemeta->name ."</a></li>". $result;
	
		}
		$parent_page=Page::find($parent_page->parent_id);
		
	}
	
		
	
	return $result;
	
}

function generatePageBreadCrumb($page_reference,$parameters = array(),$linktext=""){
	global $language_id;
	
	$page = Page::where('reference',$page_reference)->first();
	
	$pagemeta = $page->pagemetas()->where('language_id',$language_id)->first();
	
	if($linktext!=''){
		return "<li><a href='" . pagelink($page_reference,$language_id,'GET','',$parameters) . "'>" . ucfirst($linktext) . "</a></li>";
	}else{
		return "<li><a href='" . pagelink($page_reference,$language_id,'GET','',$parameters) . "'>" . ucfirst($pagemeta->name) . "</a></li>";
	}
}

function createNotification($user_id,$action,$content,$type){
	
	$notification = new Notification();
	$notification->user_id = $user_id;
	$notification->action = $action;
	$notification->content = $content;
	$notification->type = $type;
	
	$notification->save();

}

function addJsDatatableFields($data_cols) {
	$data_columns = '';
	foreach($data_cols as $name => $data) {
		$data_columns .= "{'name': '$name', 'data': '$data'}, ";
	}
	return $data_columns;
}

function UploadMediaItem() {
	/*
	returnt het toegevoegde media model
	*/

	$filename = $_FILES['file']['name'];
	$filetype = $_FILES['file']['type'];
	$filesize = $_FILES['file']['size'];
	$tmp_path = $_FILES['file']['tmp_name'];
	
	$uploadpath = UploadFile($filename,$tmp_path);
	
	$m = new Media();
	$m->name = $filename;
	$m->media_type = $filetype;
	$m->filename = $uploadpath;
	$m->filesize = $filesize;
	$m->save();
	
	switch($m->media_type){
		case "image/png":
		
		case "image/gif":

		case "image/jpeg":
		
			$image_size = getimagesize($uploadpath);
			
			$width = $image_size[0];
			$height = $image_size[1];	

			$image_versions=array();
			
			$image_versions["original"]=array($width, $height, $uploadpath);
			
			
			$image_versions["thumbnail"]= resize_image($m->media_type,$uploadpath,150,150,0);
			$image_versions["small"]= resize_image($m->media_type,$uploadpath,290,290,1); //col-md-3
			$image_versions["medium"]= resize_image($m->media_type,$uploadpath,580,580,1); //col-md-6
			$image_versions["large"]= resize_image($m->media_type,$uploadpath,1170,1170,1); //col-md-12
			
			$mm = new MediaMeta();
			$mm->media_id = $m->id;
			$mm->meta_name = 'image_width';
			$mm->meta_value = $width;
			$mm->save();
			
			$mm = new MediaMeta();
			$mm->media_id = $m->id;
			$mm->meta_name = 'image_height';
			$mm->meta_value = $height;
			$mm->save();
			
			$mm = new MediaMeta();
			$mm->media_id = $m->id;
			$mm->meta_name = 'image_versions';
			$mm->meta_value = json_encode($image_versions);
			$mm->save();
		break;
		
	}

	return $m;
}


function OverwriteMediaItem($media) {
	

	$filename = $_FILES['file']['name'];
	$filetype = $_FILES['file']['type'];
	$filesize = $_FILES['file']['size'];
	$tmp_path = $_FILES['file']['tmp_name'];
	
	$uploadpath = UploadFile($filename,$tmp_path);
	
	
	$media->name = $filename;
	$media->media_type = $filetype;
	$media->filename = $uploadpath;
	$media->filesize = $filesize;
	$media->save();
	
	switch($media->media_type){
		case "image/png":
		
		case "image/gif":

		case "image/jpeg":
		
			$image_size = getimagesize($uploadpath);
			
			$width = $image_size[0];
			$height = $image_size[1];	

			$image_versions=array();
			
			$image_versions["original"]=array($width, $height, $uploadpath);
			
			
			$image_versions["thumbnail"]= resize_image($m->media_type,$uploadpath,150,150,0);
			$image_versions["small"]= resize_image($m->media_type,$uploadpath,290,290,1); //col-md-3
			$image_versions["medium"]= resize_image($m->media_type,$uploadpath,580,580,1); //col-md-6
			$image_versions["large"]= resize_image($m->media_type,$uploadpath,1170,1170,1); //col-md-12
			
			$mm = $media->meta()->where('meta_name','image_width')->first();
			//$mm->media_id = $media->id;
			$mm->meta_name = 'image_width';
			$mm->meta_value = $width;
			$mm->save();
			
			$mm = $media->meta()->where('meta_name','image_height')->first();
			//$mm->media_id = $media->id;
			$mm->meta_name = 'image_height';
			$mm->meta_value = $height;
			$mm->save();
			
			$mm = $media->meta()->where('meta_name','image_versions')->first();
			//$mm->media_id = $media->id;
			$mm->meta_name = 'image_versions';
			$mm->meta_value = json_encode($image_versions);
			$mm->save();
		break;
		
	}

	
}

function resize_image($image_type, $image_path, $resize_width, $resize_height, $keep_ratio){
			
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
}

function isLoggedIn() {
	if (isset($_SESSION['active_user'])) {
		return true;
	}
	return false;
}

function getWeekdaysEnglish() {
	$weekdays = [];
	$weekdays[] = 'monday';
	$weekdays[] = 'tuesday';
	$weekdays[] = 'wednesday';
	$weekdays[] = 'thursday';
	$weekdays[] = 'friday';
	$weekdays[] = 'saturday';
	$weekdays[] = 'sunday';

	return $weekdays;
}

function getDealerHourTypes() {
	$hourtypes = [
		1 => ucfirst(translate('dealer_hourtypes_period', 1)),
		2 => ucfirst(translate('dealer_hourtypes_closed', 1)),
		3 => ucfirst(translate('dealer_hourtypes_appointment', 1)),
	];

	return $hourtypes;
}

function format_reference($ref) {
	//laravel str_slug kan ik niet gebruiken omdat die uppercase ook naar lowercase zet, zou problemen geven met huidige referenties
	return str_replace(' ', '-', $ref);
}

function string_to_slug($url) {
	//om een url valid te maken: str_slug kan je niet gebruiken omdat de link ook '/'' kan bevatten, en dit moet wel getoond worden
	return str_replace(' ', '-', $url);
}
?>