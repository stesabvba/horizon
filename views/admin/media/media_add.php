<?php
	
	$content.="<form role='form' enctype='multipart/form-data' method='post'  action='". actionlink('MediaController@media_add',$active_pagemeta->id) . "'>";
		$content.="<div class='modal-header'>";
			$content.="<h3>" . $active_pagemeta->title . "</h3>";
		$content.="</div>";

		$content.="<div class='modal-body'>";


		$content.="<div class='form-group'>";
		$content.="<label for='file' class='control-label'>" . ucfirst(translate('media_file')) . "</label>";
		$content.="<input type='file' class='form-control' name='file' id='file' >";
		$content.="</div>";
			
	
		
		$content.="</div>";

		$content.="<div class='modal-footer'>";
			$content.="<button type='submit' class='btn btn-primary'>". ucfirst(translate("upload")) ."</button>";
			$content.="<button type='button' class='btn btn-secondary' data-dismiss='modal'>" . ucfirst(translate("close")) . "</button>";
		$content.="</div>";
	$content.="</form>";
	

	
?>