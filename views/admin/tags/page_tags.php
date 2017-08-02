<?php
	
	$pagemetas = $template_vars['pagemetas'];

?>
<div class="row">
	
	<div class="col-md-6">
		

		<div class="form-group">
			<label for="page_meta_id" class="control-label"><?php echo(ucfirst(translate('page'))); ?></label>
			<select class='form-control select2' name='page_meta_id' id='page_meta_id' required>
				<?php

					foreach($pagemetas as $pagemeta)
					{
						echo("<option value='" . $pagemeta->id . "'>" . $pagemeta->title . "</option>");

					}

				?>
			</select>
		</div>






	</div>

	<div class="col-md-6">

	</div>


</div>

<div class="row">
	<div id='page_tag_list'>



	</div>
</div>