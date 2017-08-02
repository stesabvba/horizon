<?php
$start = microtime();
	function ShowUserRights($id,&$profile)
	{
	
		$output="";
		$userrights = UserRight::where('parent_id',$id)->get();
		
		if(count($userrights)>0){
	
			//$output="<ul id='$id' class='droppable ui-widget-header'>";
			$output="<ul id='' class=''>";
			foreach($userrights as $userright){
				$userright_id=$userright->id;

				if($profile->userrights->find($userright->id)!=null) {
					$str_checked = ' checked="checked" ';
				} else {
					$str_checked = '';
				}
				
				//$output.="<li id='$userright_id' class='draggable ui-widget-content'><input class='userright' id='userright_$userright_id' type='checkbox' name='userrights[$userright_id]' ".$str_checked." /> " . translate($userright->name);	

				//$output.= '<li id="'.$userright_id.'" class="draggable ui-widget-content"><input class="userright" id="userright_'.$userright_id.'" type="checkbox" name="userrights[]" value="'.$userright_id.'" '.$str_checked.' />'.translate($userright->name);

				$output.= '<li><input class="userright" type="checkbox" name="userrights[]" value="'.$userright_id.'" '.$str_checked.' />'.$userright->name;

				$output.=ShowUserRights($userright->id,$profile);
				
				$output.="</li>";
			}
			$output.="</ul>";
		}else{
			//$output="<ul id='$id' class='droppable ui-widget-header'><li></li></ul>";
			//$output="<ul id=''><li></li></ul>";
		}
		
		
		return $output;
	}
	
	if(isset($parameters[0])){
		$profile_id=$parameters[0];
	}else{
		$profile_id=0;
	}
	
	$profile = Profile::find($profile_id);

	$content.="<form id='order' class='form-horizontal' role='form' data-toggle='validator' action='" . pagelink('profile_edit',$language_id,'POST','ProfileController@profile_edit') ."' method='POST'>";
	$content.="<div class='panel panel-default'>";
	$content.="<div class='panel-heading'>" . ucfirst(translate('profile_edit')) . "</div>";
	$content.="<div class='panel-body'>";
	$content.="<input type='hidden' name='form_action' value='profile_edit'/>";
	$content.="<input type='hidden' name='profile_id' value='" . $profile_id . "'/>";
	//REFERENCE
	$content.="<div class='form-group'>";
	$content.="<label for='name' class='col-md-4 control-label'>" . ucfirst(translate('name')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<input name='name' id='name' type='text' class='form-control' value='" . $profile->name . "' required/>";
	$content.="</div>";
	$content.="</div>";
	//END
	
	//ENDUSER
	
	$content.="<div class='form-group'>";
	$content.="<div class='col-md-6 col-md-offset-4'>";
    $content.="<div class='checkbox'>";

    $str_checked = ($profile->enduser==1)?' checked="checked" ':'';
	$content.="<label><input type='checkbox' name='enduser' id='enduser' ".$str_checked." />" . ucfirst(translate('profile_enduser')) . "</label>";	
	
	$content.="</div>";
   	$content.="</div>";
	$content.="</div>";
	//END 
	
	
	//ACTIVE
	
	$content.="<div class='form-group'>";
	$content.="<div class='col-md-6 col-md-offset-4'>";
    $content.="<div class='checkbox'>";

    $str_checked = ($profile->active==1)?' checked="checked" ':'';
	$content.="<label><input type='checkbox' name='active' id='active' ".$str_checked." />" . ucfirst(translate('profile_active')) . "</label>";	
	
	$content.="</div>";
   	$content.="</div>";
	$content.="</div>";
	//END 
	
	//USERRIGHTS
	$content.="<div class='form-group'>";
	$content.="<label for='name' class='col-md-4 control-label'>" . ucfirst(translate('profile_userrights')) . "</label>";
	$content.="<div class='col-md-6'>";
	$content.="<a class='btn btn-default' data-toggle='modal' data-target='#modal' href='" . pagelink('userright_add',$language_id) . "'>" . ucfirst(translate('userright_add')) . '</a><br/><br/>';
	
	$content.="<label><input id='select_all' type='checkbox' >" . ucfirst(translate('select_all_userrights')) . "</label>";
	$content.=ShowUserRights(0,$profile);
	

	$content.="</div>";
	$content.="</div>";
	//END
	
	
	
	
	$content.="<div class='form-group'>";
	$content.="<div class='col-md-6 col-md-offset-4'>";
	$content.="<button type='submit' class='btn btn-primary'><i class='fa fa-btn fa-sign-in'></i> " . ucfirst(translate("update")) . "</button>";
	$content.="</div>";
	$content.="</div>";
	
	$content.=("</div>");
	$content.=("</div>");
	$content.=("</div>");
	$content.="</form>";
	
	
	//$script.="$('ul.droppable').sortable({ revert: true});";
	//$script.="$('li.draggable').draggable({ connectToSortable: 'ul.droppable'});";

	/*$script.="$('ul.droppable').droppable({ accept: 'li.draggable', greedy: true, drop: function(event, ui){ 
				
				var postdata='form_action=move_userright&from=' + ui.draggable.attr('id') + '&to=' + $(this).attr('id');
				$.ajax({
				type: 'POST',
				url: '" . $site_config['site_url']->value . 'modules/config/post_handler.php' . "',
				data: postdata,
				success: function (result){ 
				}});
			}});";
	$script.="$('.userright').on('change',function(){ 
					var checked = $(this).prop('checked');
					
					var userrights = $(this).parent().find('li .userright');
					userrights.each(function(){ $(this).prop('checked', checked); });
					
					

			});";*/

$script.="$('#select_all').on('click',function(){ 
	
		var checked = this.checked;
		 if(checked) {
			 $(':checkbox').prop('checked',checked);
		 }else{
			 $(':checkbox').prop('checked',checked);
		 }
	});";
				$stop = microtime();

	$content.=$stop-$start . " seconds";
?>