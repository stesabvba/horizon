<?php
	if(isset($parameters[0])){
		$route_id=$parameters[0];
	}else{
		$route_id=0;
	}

	$content.="<form role='form' method='post' action='". actionlink('RouteController@route_delete',$active_pagemeta->id) . "'>";
	
		$content.="<div class='modal-header'>";
			$content.="<h3>" . $active_pagemeta->title . "</h3>";
		$content.="</div>";

		$content.="<div class='modal-body'>";

			$content.="<input type='hidden' name='route_id' value='". $route_id .  "'>";
			$content.=translate('route_delete',TEXT);
					
		$content.="</div>";

		$content.="<div class='modal-footer'>";
			$content.="<button type='submit' class='btn btn-danger'>". ucfirst(translate("yes")) ."</button>";
			$content.="<button type='button' class='btn btn-secondary' data-dismiss='modal'>" . ucfirst(translate("no")) . "</button>";
		$content.="</div>";
	$content.="</form>";


       
?>