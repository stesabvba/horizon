<?php
$imagecollections = $template_vars['imagecollections'];
$paginator = $template_vars['paginator'];
?>
<div class="col-md-8">
	<?php echo($paginator); ?>
</div>

<div class="col-md-4">
	<?php echo $template_vars['lbl_items_found']; ?>
</div>
<table id='translations' class='table table-striped'>
	<thead>
		<tr>
			<th width="50"><?php echo ucfirst(translate("id")); ?></th>
			<th><?php echo ucfirst(translate("name")); ?></th>			
			<th><?php echo ucfirst(translate("media")); ?></th>
			<th><?php echo ucfirst(translate("edit")); ?></th>
			<th><?php echo ucfirst(translate("delete")); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		if (!empty($imagecollections)) {
			foreach($imagecollections as $item) {
				?>
				<tr>
					<td><?php echo $item->id; ?></td>
					<td><?php echo $item->name; ?></td>
					<td class="action">
						<a class="btn btn-default btn-edit" href="<?php echo $template_vars['url_media_overview'].'/'.$item->id; ?>"><?php echo ucfirst(translate('media')); ?></a>
					</td>
					<td class="action">
						<a class="btn btn-default btn-edit" href="<?php echo $template_vars['url_edit'].'/'.$item->id; ?>"><?php echo ucfirst(translate('edit')); ?></a>
					</td>					
					<td class="action">
						<a class="btn btn-warning btn-danger btn-delete" data-toggle="modal" data-target="#modal" href="<?php echo $template_vars['url_delete'].'/'.$item->id; ?>"><?php echo ucfirst(translate('delete')); ?></a>
					</td>
				</tr>
				<?php
			}
		}
		?>
	</tbody>
</table>