<div class="col-md-12">
	<form class="form-horizontal" method="GET">
		<div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo ucfirst(translate('tag')); ?>:</label>
		    <div class="col-sm-10">
		      	<select name="tag_id" id="tag_id" class="form-control select2">
		      		<option value="0"></option>
		      		<?php
		      		if (!empty($template_vars['tags'])) {
		      			foreach($template_vars['tags'] as $tag) {
		      				$str_sel = ($tag->id == $template_vars['tag_id'])?' selected="selected" ':'';
		      				echo '<option value="'.$tag->id.'" '.$str_sel.'>'.$tag->name.' ('.$tag->language->shortname.') ('.$tag->id.')</option>';
		      			}
		      		}
		      		?>
				</select>
		    </div>
		  </div>
		<?php
		/*
		if (!empty($template_vars['tag_id'])) {
		?>
		<!-- <div class="form-group">
			<label class="col-sm-2 control-label">Child:</label>
			<div class="col-sm-10">
				<select name="parent_tag_id" id="parent_tag_id" class="form-control select2">
					<option value="0"></option>
				<?php
				if ($template_vars['ddl_parent_tags']->count() > 0) {
					foreach($template_vars['ddl_parent_tags'] as $tag) {
						$str_sel = ($tag->id == $template_vars['parent_tag_id'])?' selected="selected" ':'';
						echo '<option value="'.$tag->id.'" '.$str_sel.'>'.$tag->name.' ('.$tag->language->shortname.') ('.$tag->id.')</option>';
					}
				}
				?>
				</select>
			</div>			
		</div> -->
		<?php
		}
		*/
		?>
	</form>
	<div class="alert alert-info">
		<?php echo ucfirst(translate('drag_and_drop_the_items_to_change_the_sorting_order')); ?>
	</div>
	<?php
	if (!empty($template_vars['media_tags'])) {
		$b_reorder = empty($template_vars['parent_tag_id'])?true:false;
		$cls = $b_reorder?' js_media_tags_list ':'';

		echo '<ul id="media_tags_list" class="'.$cls.' reorder_list">';
		foreach($template_vars['media_tags'] as $tag_id => $media_list) {
			$b_reorder = empty($template_vars['parent_tag_id'])?true:false;
			$cls = $b_reorder?' js_media_tags_list ':'';

			$tag = Tag::find($tag_id);
			$str_id = '';
			if ($b_reorder) {
				//$str_id = ' id="sortable_'.$media_list[0]->id.'" ';
				$str_id = ' id="sortable_'.$tag->id.'" ';
			}
			echo '<li '.$str_id.' class="pointer">';	
				echo '<div class="row row_title">';
					echo '<div class="col-md-12">';
						echo $tag->name.' ('.$tag->id.')';
					echo '</div>';
				echo '</div>';

				echo '<div class="row">';
					echo '<div class="col-md-12">';
						$b_reorder = !empty($template_vars['parent_tag_id'])?true:false;
						$cls = $b_reorder?' js_media_tags_list ':'';
						echo '<ul class="media_items_list '.$cls.' reorder_list">';
						foreach($media_list as $media) {
							$str_id = '';
							if ($b_reorder) {
								$str_id = ' id="sortable_'.$media->id.'" ';
							}
							echo '<li '.$str_id.'>';
								echo '<div class="row">';
									echo '<div class="col-sm-1">';
										echo $media->pivot->presentation_order;
									echo '</div>';
									echo '<div class="col-sm-11">';					
										echo "<a href='".$site_config['site_url']->value.$media->filename."' target='_blank'>".$media->name." (pivot id=".$media->pivot->id.", media id=".$media->id.")</a>";
									echo '</div>';
									/*echo '<div class="col-sm-2">';		
										echo 'hier komt de delete knop';
									echo '</div>';*/
								echo '</div>';
							echo '</li>';
						}
						echo '</ul>';
					echo '</div>';
				echo '</div>';
			echo '</li>';
		}
		echo '</ul>';
	}
	?>
</div>