<?php
	$actionlink = $template_vars['actionlink'];
	$media_id = $template_vars['media_id'];
	$tags = $template_vars['tags'];
	$media_tags = $template_vars['media_tags'];

?>
<form method='post' action='<?php echo($actionlink); ?>'>
<div class='modal-header'>
	<h3><?php echo($active_pagemeta->title); ?></h3>
</div>

<div class="modal-body">
	<input type='hidden' name='media_id' value='<?php echo($media_id); ?>'/>

	<div class="form-group">
		
		<select name='tags[]' id='tags' class='form-control select2' multiple="multiple">
			<?php

				foreach($tags as $tag)
				{

					
					if($media_tags->contains("id",$tag->id))
					{
						
						echo("<option value='" . $tag->id . "' selected>[" . $tag->language->shortname . "] " . $tag->name . " (".$tag->id.")</option>");
					}else{
						echo("<option value='" . $tag->id . "'>[" . $tag->language->shortname . "] " . $tag->name . " (".$tag->id.")</option>");
					}
					
				}
			?>
		</select>
	</div>
</div>

<div class="modal-footer">
	<button type='submit' class='btn btn-primary'><?php echo(ucfirst(translate("add"))); ?></button>
	<button type='button' class='btn btn-secondary' data-dismiss='modal'><?php echo(ucfirst(translate("close"))); ?></button>
</div>
</form>
