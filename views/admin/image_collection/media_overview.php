<div class="row">
	<div class="col-md-12">
		<?php echo ucfirst(translate('collection')); ?>: <?php echo $template_vars['image_collection']->name; ?>
	</div>
</div>
<div class="row" id="row-overview-actions">
	<div class="col-md-12">
		<a class="btn btn-default btn-add pull-right" data-toggle="modal" data-target="#modal" href="<?php echo pagelink('image_collection_media_add',$language_id).'/'.$template_vars['image_collection']->id; ?>"><?php echo ucfirst(translate('media_add')); ?></a>


		<a class="btn btn-default btn-add pull-right" data-toggle="modal" data-target="#modal" href="<?php echo $template_vars['url_choose']; ?>"><?php echo ucfirst(translate('media_choose')); ?></a>
	</div>
</div>

<table class='table'>
	<tr>
		<th width="50"><?php echo ucfirst(translate("id")); ?></th>
		<th><?php echo ucfirst(translate("name")); ?></th>
		<th>Thumbnail</th>
		<th class="action">&nbsp;</th>
	</tr>
<?php
if (!empty($template_vars['contents'])) {
	foreach($template_vars['contents'] as $col_content) {
		$item = $col_content->media;

		if (in_array($item['media_type'], ['image/jpeg'])) {
			$b_has_thumb = 	true;
		} else {
			$b_has_thumb = false;
		}
	?>
		<tr>
			<td><?php echo $item->id; ?></td>
			<td>
				<a href="<?php echo $site_config['site_url']->value.$item->filename; ?>" target="_blank"><?php echo $item->name; ?></a>
			</td>
			<td>
				<?php
				if ($b_has_thumb) {
					echo '<div class="thumb">';
						echo GetMediaImage($item->id, 'thumbnail');
					echo '</div>';					
				}
				?>
			</td>
			<td class="action">
				<?php
				$base_url_delete = $template_vars['url_delete'].'?image_collection_id='.$template_vars['image_collection']->id.'&image_collection_content_id='.$col_content->id;
				?>
				<a class='btn btn-danger btn-delete' data-toggle='modal' data-target='#modal' href="<?php echo $base_url_delete.'&full_delete=1'; ?>"">media + item</a>
				<a class='btn btn-danger btn-delete' data-toggle='modal' data-target='#modal' href="<?php echo $base_url_delete; ?>""><?php echo ucfirst(translate('delete')); ?></a>
			</td>
		</tr>
	<?php	
	}
}
?>
</table>