<?php
$content.="<form role='form' method='post'>";
	$content.="<div class='modal-header'>";
		$content.="<h3>" . $active_pagemeta->title . "</h3>";
	$content.="</div>";

	$content.="<div class='modal-body'>";

		$content.="<input type='hidden' name='form_action' value='mailinglist_add'>";
		$content.="<div class='form-group'>";
			$content.="<label for='name' class='form-control-label'>" . ucfirst(translate('name')) . ":</label>";
			$content.="<input type='text' name='name' class='form-control' required>";
		$content.="</div>";

		$content.="<div class='form-group'>";
			$content.="<div class='checkbox'>";
				$content.="<label><input name='enduser' type='checkbox'>" . ucfirst(translate('end_user')) . "</label>";
			$content.="</div>";
		$content.="</div>";
				
	$content.="</div>";

	$content.="<div class='modal-footer'>";
		$content.="<button type='submit' class='btn btn-primary'>". ucfirst(translate("add")) ."</button>";
		$content.="<button type='button' class='btn btn-secondary' data-dismiss='modal'>" . ucfirst(translate("close")) . "</button>";
	$content.="</div>";
$content.="</form>";
       
?>