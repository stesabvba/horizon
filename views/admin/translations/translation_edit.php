<form role='form' method='post' action="<?php echo actionlink($template_vars['actionlink'],$active_pagemeta->id); ?>">
	<div class="modal-header">
		<h3><?php echo $active_pagemeta->title; ?></h3>
	</div>
	<div class="modal-body">

		<?php
			if($template_vars['vision_translation']==1)
			{
		?>
			<div class="alert alert-danger">
				Opgelet! Wijzigingen aan deze vertaling zullen onmiddellijk aangepast worden in Vision!
			</div>

		<?php
			}

		?>

		<input type="hidden" name="vision_translation" value="<?php echo($template_vars['vision_translation']); ?>"/>

		<div class="form-group">
			<label for="reference" class="control-label"><?php echo ucfirst(translate('reference')); ?></label>
			<input name="reference" id="reference" type="text" class="form-control" value="<?php echo e($template_vars['translation']->reference); ?>" />
		</div>

		<div class="form-group">
			<label for="type" class="control-label"><?php echo ucfirst(translate('type')); ?></label>
			<select name="type" id="type" class="form-control select2">
				<?php
				if (!is_null($template_vars['field_types'])) {
					foreach($template_vars['field_types'] as $id_field_type => $lbl) {
						$str_sel = ($id_field_type == $template_vars['translation']->type)?' selected="selected" ':'';
						echo '<option value="'.$id_field_type.'" '.$str_sel.'>'.$lbl.'</option>';	
					}
				}
				?>
			</select>
		</div>
		<?php
		if (!empty($template_vars['translations'])) {
			foreach($template_vars['translations'] as $transl) {
		?>
		<div class="form-group">
			<label class="control-label"><?php echo ucfirst(translate('reference')).' '.$transl->language->shortname; ?></label>
			<?php
				if ($template_vars['translation']->type == 2) {
			?>
				<textarea name="translations[<?php echo $transl->language->id; ?>]" class="form-control editor"><?php echo e($transl->translation); ?></textarea>
			<?php
				} else {
			?>
				<input name="translations[<?php echo $transl->language->id; ?>]" type="text" class="form-control" value="<?php echo e($transl->translation); ?>" />
		</div>
		<?php
				}

			?>
				<div class="checkbox">
					<label><input type='checkbox' name='needs_review[<?php echo $transl->language->id; ?>]' <?php if($transl->unstable==1){ echo('checked'); } ?>/><?php echo(translate('needs_review')); ?></label>
				</div>


			<?php
			}
		}
		?>
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-danger"><?php echo ucfirst(translate("yes")); ?></button>
		<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo ucfirst(translate("no")); ?></button>
	</div>	
</form>

<script>
$(document).ready(function() {
	tinymce.init({
		selector: '.editor',
		height:150,
		plugins: "paste",
		paste_as_text: true,
		relative_urls: false,
		remove_script_host: false,
		toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
		menubar: false,
		setup: function (editor) {
        editor.on('change', function () {
            editor.save();
        });},
		force_br_newlines : true,
		force_p_newlines : false,
		forced_root_block : '',
	});


});
</script>