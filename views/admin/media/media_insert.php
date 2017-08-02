<?php


	$content.="<form id='insertmedia' role='form' method='post' action='". actionlink('MediaController@media_insert',$active_pagemeta->id) . "'>";
		$content.="<div class='modal-header'>";
			$content.="<h3>" . $active_pagemeta->title . "</h3>";
		$content.="</div>";

		$content.="<div class='modal-body'>";
		$content.="<div class=''>";
		$content.="<div class='row'>";
		$medias = Media::all();
			$content.="<div class='col-md-9'>";
			
			
			foreach($medias as $media){
			
				$media_id = $media->id;
				$content.="<div class='thumbnail col-md-3'>";
				
				switch($media->media_type){
					
					case "image/png":
				
					case "image/gif":

					case "image/jpeg":
					
					$meta = $media->meta()->where('meta_name','image_versions')->first();
					
					if($meta!=null){
					
						$image_versions = json_decode($meta->meta_value,true);
						if(isset($image_versions['thumbnail'])){
						
							$content.=("<img src='" . $site_config['site_url']->value . $image_versions['thumbnail'][2] . "'/>");
							$content.="<input class='media' type='radio' name='media_id' value='$media_id'/>";
						}
					}
					
					break;
					
					default:
					
					$content.=$media->name;
					$content.="<input class='media' type='radio' name='media_id' value='$media_id'/>";
					
					break;
					
				}
				
				$content.="</div>";
				
			}
			$content.="</div>";
		
			$content.="<div id='sidebar' class='col-md-3'>";
			
			$content.="</div>";
		
		$content.="</div>";
		
		$content.="</div>";
		$content.="</div>";

		$content.="<div class='modal-footer'>";
		$content.="<button type='button' id='inject' class='btn btn-primary'>Inject!</button>";
		
		$content.="</div>";
		
		$content.="</form>";
		
		
		$script.="
			$('.media').on('click',function(){  
		
			var media_id = $(this).val();
			
			var postdata = 'media_id=' + media_id;
			$.ajax({
				type: 'POST',
				url: '". actionlink('MediaController@getmediameta',$active_pagemeta->id) . "',
				data: postdata,
				success: function(result){ 
					
					$('#sidebar').html(result);
				
				}
			});
			
		
		});";
		
		$script.="$('#inject').on('click',function(){ 
		
			var postdata = $('#insertmedia').serialize();
			$.ajax({
				type: 'POST',
				url: '". actionlink('MediaController@media_insert',$active_pagemeta->id) . "',
				data: postdata,
				success: function(result){ 
					
				
					
					tinymce.activeEditor.execCommand('mceInsertContent',false,result);
					
					$('#modal').modal('hide');
					
					
				}
			});
			

		});";

?>