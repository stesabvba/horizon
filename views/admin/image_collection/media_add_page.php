
<form role='form' enctype='multipart/form-data' method='post'  action='<?php echo $template_vars['url_post']; ?>'>
	<div class='modal-header'>
		<h3><?php echo $active_pagemeta->title; ?></h3>
	</div>

	<div class='modal-body'>
		<div class='form-group'>
			<label for='file' class='control-label'><?php echo ucfirst(translate('image')); ?></label>
			<input type='file' class='form-control' name='file' id='file' >
		</div>
	</div>

	<div class='modal-footer'>
		<button type='submit' class='btn btn-primary'><?php echo ucfirst(translate("upload")); ?></button>
		<button type='button' class='btn btn-secondary' data-dismiss='modal'><?php echo ucfirst(translate("close")); ?></button>
	</div>
</form>