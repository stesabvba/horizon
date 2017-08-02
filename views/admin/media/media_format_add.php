<?php
	$actionlink = $template_vars['actionlink'];
	$media_id = $template_vars['media_id'];
?>
<form method='post' action='<?php echo($actionlink); ?>'>
<div class='modal-header'>
	<h3><?php echo($active_pagemeta->title); ?></h3>
</div>

<div class="modal-body">
	<input type='hidden' name='media_id' value='<?php echo($media_id); ?>'/>
 	<div class="form-group">
		<label for='name'><?php echo(ucfirst(translate('format_name'))); ?></label>
		<input type='text' name='name' id='name' value='' required class='form-control' />
	</div>

	<div class="form-group">
		<label for='width'><?php echo(ucfirst(translate('width'))); ?></label>
		<input type='text' name='width' id='width' value='' required class='form-control' />
	</div>

	<div class="form-group">
		<label for='height'><?php echo(ucfirst(translate('height'))); ?></label>
		<input type='text' name='height' id='height' value='' required class='form-control' />
	</div>
	<div class="checkbox">
		<label><input type="checkbox" name="keep_ratio" checked><?php echo(ucfirst(translate('keep_ratio'))); ?></label>
	</div>
</div>

<div class="modal-footer">
	<button type='submit' class='btn btn-primary'><?php echo(ucfirst(translate("add"))); ?></button>
	<button type='button' class='btn btn-secondary' data-dismiss='modal'><?php echo(ucfirst(translate("close"))); ?></button>
</div>
</form>