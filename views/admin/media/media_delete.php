<?php
	if(isset($parameters[0])){
		$media_id=$parameters[0];
	}else{
		$media_id=0;
	}

	$content.="<form role='form' id='media_delete_form'>";
	
	$content.="<div class='modal-header'>";
		$content.="<h3>" . $active_pagemeta->title . "</h3>";
	$content.="</div>";

	$content.="<div class='modal-body'>";

		$content.="<input type='hidden' name='media_id' value='". $media_id .  "'>";
		$content.=translate('media_delete',TEXT);
				
	$content.="</div>";

	$content.="<div class='modal-footer'>";
		$content.="<button type='button' id='btn_delete' class='btn btn-danger'>". ucfirst(translate("yes")) ."</button>";
		$content.="<button type='button' class='btn btn-secondary' data-dismiss='modal'>" . ucfirst(translate("no")) . "</button>";
	$content.="</div>";
$content.="</form>";

	$script.="

		$('#btn_delete').on('click',function(){
			var postdata = $('#media_delete_form').serialize();

			$.ajax({
			type: 'POST',
			url: '" . actionlink('MediaController@media_delete',$active_pagemeta->id) . "',
			data: postdata,
			success: function (result){ 
					window.parent.medialibrary.getmedialist();
					$('#modal').modal('hide');
				}
			});

		});
       ";
?>