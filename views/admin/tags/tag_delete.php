<?php
	$actionlink = $template_vars['actionlink'];
	$tag = $template_vars["tag"];
?>
<form method='post' action='<?php echo($actionlink); ?>'>
<div class='modal-header'>
	<h3><?php echo($active_pagemeta->title); ?></h3>
</div>

<div class="modal-body">
	<input type='hidden' name='tag_id' value='<?php echo($tag->id); ?>'/>
	<p><?php echo(translate("tag_delete_text",TEXT)); ?></p>
</div>

<div class="modal-footer">
	<button type='submit' class='btn btn-danger'><?php echo(ucfirst(translate("yes"))); ?></button>
	<button type='button' class='btn btn-secondary' data-dismiss='modal'><?php echo(ucfirst(translate("no"))); ?></button>
</div>
</form>
