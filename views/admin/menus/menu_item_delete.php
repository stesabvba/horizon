<?php
	if(isset($parameters[0])){
		$menu_item_id=$parameters[0];
	}else{
		$menu_item_id="";
	}

	$content.="<form role='form' method='post' action='". actionlink('MenuController@menu_item_delete',$active_pagemeta->id) . "'>";
	
	$content.="<div class='modal-header'>";
		$content.="<h3>" . $active_pagemeta->title . "</h3>";
	$content.="</div>";

	$content.="<div class='modal-body'>";

		$content.="<input type='hidden' name='menu_item_id' value='". $menu_item_id .  "'>";
		$content.=translate('menu_item_delete',TEXT);
				
	$content.="</div>";

	$content.="<div class='modal-footer'>";
		$content.="<button type='submit' class='btn btn-danger'>". ucfirst(translate("yes")) ."</button>";
		$content.="<button type='button' class='btn btn-secondary' data-dismiss='modal'>" . ucfirst(translate("no")) . "</button>";
	$content.="</div>";
$content.="</form>";
       
?>