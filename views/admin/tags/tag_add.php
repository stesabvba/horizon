<?php
	$actionlink = $template_vars['actionlink'];
	$languages = $template_vars['languages'];

?>
<form method='post' action='<?php echo($actionlink); ?>'>
<div class='modal-header'>
	<h3><?php echo($active_pagemeta->title); ?></h3>
</div>

<div class="modal-body">
	<div class="form-group">
		<label for='language_id'><?php echo(ucfirst(translate('language'))); ?></label>
		<select name='language_id' id='language_id' class='form-control'>
			<option></option>
			<?php
				foreach($languages as $language)
				{
					echo("<option value='" . $language->id ."'>" . $language->name ."</option>");
				}				

			?>
		</select>
	</div>

	<div class="form-group">
		<label for="name">
			<?php echo(ucfirst(translate('name'))); ?>
		</label>
		<input type="text" name='name' value='' class='form-control' required>
		<p>Meerdere tags kunnen ingegeven worden indien gescheiden door ;</p>
	</div>
</div>

<div class="modal-footer">
	<button type='submit' class='btn btn-primary'><?php echo(ucfirst(translate("add"))); ?></button>
	<button type='button' class='btn btn-secondary' data-dismiss='modal'><?php echo(ucfirst(translate("close"))); ?></button>
</div>
</form>
