<form role='form' enctype='multipart/form-data' method='post'  action="<?php echo $template_vars['url_choose']; ?>">
	<input type="hidden" name="image_collection_id" value="<?php echo $template_vars['image_collection']->id; ?>" />

	<div class='modal-header'>
		<h3><?php echo $active_pagemeta->title; ?></h3>
	</div>

	<div class='modal-body'>
		<div class="row">
			<div class="col-md-12">
				<?php echo ucfirst(translate('image_collection')); ?>: <?php echo $template_vars['image_collection']->name; ?>
			</div>
		</div>
		<div class="row" id="row-overview-actions">
			<div class="col-md-12">
				<button class="btn btn-default btn-add pull-right" type="submit" name="add_selected"><?php echo ucfirst(translate('add_selected')); ?></button>
			</div>
		</div>

		<table class='table'>
			<tr>
				<th>
					<input type="checkbox" class="js-toggle-checkbox" data-toggle=".js-checkbox" />
				</th>
				<th><?php echo ucfirst(translate("id")); ?></th>
				<th>Thumbnail</th>
				<th><?php echo ucfirst(translate("name")); ?></th>
			</tr>
		<?php
		if (!empty($template_vars['media'])) {
			foreach($template_vars['media'] as $item) {
				if (in_array($item['media_type'], ['image/jpeg'])) {
					$b_has_thumb = 	true;
				} else {
					$b_has_thumb = false;
				}
			?>
				<tr>
					<td><input type="checkbox" name="selected_items[]" class="js-checkbox" value="<?php echo $item->id; ?>" />
					<td><?php echo $item->id; ?></td>
					<td>
						<?php
						if ($b_has_thumb) {
							echo '<div class="thumb">';
								echo GetMediaImage($item->id, 'thumbnail');
							echo '</div>';					
						}
						?>
					</td>
					<td>
						<a href="<?php echo $site_config['site_url']->value.$item->filename; ?>" target="_blank"><?php echo $item->name; ?></a>
					</td>
				</tr>
			<?php	
			}
		}
		?>
		</table>
	</div>

	<div class='modal-footer'>
		<button type='submit' class='btn btn-primary'><?php echo ucfirst(translate("upload")); ?></button>
		<button type='button' class='btn btn-secondary' data-dismiss='modal'><?php echo ucfirst(translate("clos	e")); ?></button>
	</div>
</form>

