<?php
	if(isset($parameters[0])){
		$translation_id=$parameters[0];
	}else{
		$translation_id=0;
	}
	
	$translation = Translation::find($translation_id);
	
	if($translation==null){
		
		header('Location: ' . pagelink('translations',$language_id));
		
	}
	
	$content.="<form role='form' method='post' action='". actionlink('TranslationController@translation_delete',$active_pagemeta->id) . "'>";
		$content.="<div class='modal-header'>";
			$content.="<h3>" . $active_pagemeta->title . "</h3>";
		$content.="</div>";

		$content.="<div class='modal-body'>";

			$content.="<input type='hidden' name='form_action' value='translation_delete'>";
			$content.="<input type='hidden' name='translation_id' value='". $translation_id .  "'>";
			$content.=translate('delete_translation',TEXT);
					
		$content.="</div>";

		$content.="<div class='modal-footer'>";
			$content.="<button type='submit' class='btn btn-danger'>". ucfirst(translate("yes")) ."</button>";
			$content.="<button type='button' class='btn btn-secondary' data-dismiss='modal'>" . ucfirst(translate("no")) . "</button>";
		$content.="</div>";
	$content.="</form>";


?>