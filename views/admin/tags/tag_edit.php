<?php
	$actionlink = $template_vars['actionlink'];
	$languages = $template_vars['languages'];
	$tag = $template_vars['tag'];
?>
<form method='post' action='<?php echo($actionlink); ?>'>
<div class='modal-header'>
	<h3><?php echo($active_pagemeta->title); ?></h3>
</div>

<div class="modal-body">
	<input type='hidden' name='tag_id' value='<?php echo($tag->id); ?>'/>
	<div class="form-group">
		<label for='language_id'><?php echo(ucfirst(translate('language'))); ?></label>
		<select name='language_id' id='language_id' class='form-control'>
			<option></option>
			<?php
				foreach($languages as $language)
				{
					if($tag->language_id==$language->id)
					{
						echo("<option value='" . $language->id ."' selected>" . $language->name ."</option>");
					}else{
						echo("<option value='" . $language->id ."'>" . $language->name ."</option>");
					}
					
				}				

			?>
		</select>
	</div>

	<div class="form-group">
		<label for="name">
			<?php echo(ucfirst(translate('name'))); ?>
		</label>
		<input type="text" name='name' class='form-control' value='<?php echo($tag->name); ?>' required>
	</div>
</div>

<div class="modal-footer">
	<button type='submit' class='btn btn-primary'><?php echo(ucfirst(translate("update"))); ?></button>
	<button type='button' class='btn btn-secondary' data-dismiss='modal'><?php echo(ucfirst(translate("close"))); ?></button>
</div>
</form>
