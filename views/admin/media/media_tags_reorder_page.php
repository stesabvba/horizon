<div class="col-md-12">
	<form class="form-horizontal" method="GET">
		<div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo ucfirst(translate('language')); ?>:</label>
		    <div class="col-sm-10">
		      	<select name="lang_id" id="lang_id" class="form-control select2">
		      		<option value="0"></option>
		      		<?php
		      		if (!empty($template_vars['languages'])) {
		      			foreach($template_vars['languages'] as $lang) {
		      				$str_sel = ($lang->id == $template_vars['lang_id'])?' selected="selected" ':'';
		      				echo '<option value="'.$lang->id.'" '.$str_sel.'>'.$lang->name.' ('.$lang->shortname.') ('.$lang->id.')</option>';
		      			}
		      		}
		      		?>
				</select>
		    </div>
		</div>		
	</form>
	<div class="alert alert-info">
		<?php echo ucfirst(translate('drag_and_drop_the_items_to_change_the_sorting_order')); ?>
	</div>
	<?php
	if (!empty($template_vars['tags'])) {
		echo '<ul id="tags_list" class="reorder_list">';
		foreach($template_vars['tags'] as $tag) {
			echo '<li id="sortable_'.$tag->id.'" class="pointer">';	
				echo '<div class="row">';
					echo '<div class="col-sm-1">';
						echo $tag->presentation_order;
					echo '</div>';
					echo '<div class="col-sm-11">';					
						echo $tag->name.' ('.$tag->id.')';
					echo '</div>';
					/*echo '<div class="col-sm-2">';		
						echo 'hier komt de delete knop';
					echo '</div>';*/
				echo '</div>';
			echo '</li>';
		}
		echo '</ul>';
	}
	?>
</div>