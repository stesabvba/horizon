<form role="form" method="post" action="<?php echo actionlink($template_vars['actionlink'],$active_pagemeta->id); ?>">		
	<div class="modal-header">
		<h3><?php echo $active_pagemeta->title; ?></h3>
	</div>

	<div class="modal-body">
		<?php
		if (!empty($template_vars['hidden_fields'])) {
			foreach($template_vars['hidden_fields'] as $field_name => $field_val) {
				echo '<input type="hidden" name="'.$field_name.'" value="'.$field_val.'" />';
			}
		}
		echo translate('delete_confirm_text', TEXT); 
		?>
	</div>

	<div class="modal-footer">
		<button type="submit" class="btn btn-danger"><?php echo ucfirst(translate("yes")); ?></button>

		<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo ucfirst(translate("no")); ?></button>		

	</div>
</form>   