<?php
	$medias = $template_vars['medias'];
	
?>
<?php echo($template_vars['paginator']); ?>
<form method="post" action="<?php echo pagelink('media_scan', $language_id, 'POST'); ?>">
	
	<button type="submit" name="media_scan" class="btn"><?php echo ucfirst(translate('media_scan')); ?></button>

	<table class='table'>
		<tr>
			<th>
				<input type="checkbox" class="js-toggle-checkbox" data-toggle=".js-checkbox" />
			</th>
			<th><?php echo ucfirst(translate("id")); ?></th>
			<th><?php echo ucfirst(translate("name")); ?></th>
			<th><?php echo ucfirst(translate("status")); ?></th>
			<th><?php echo ucfirst(translate("tags")); ?></th>
			<th></th>
		</tr>

	<?php
	if (!empty($medias)) {
		foreach($medias as $media) {	
	?>
		<tr class="media" id="<?php echo($media->id); ?>">
			<td><input type="checkbox" name="selected_items[]" class="js-checkbox" value="<?php echo $media->id; ?>" />
			<td><?php echo $media->id; ?></td>
			<td>
				<?php
				if (in_array($media->media_type, $template_vars['types_images'])) {
					$b_hasthumb = false;
					$meta = $media->meta()->where('meta_name','image_versions')->first();
					if (!is_null($meta)) {						
						$image_versions = json_decode($meta->meta_value,true);
						if(isset($image_versions['thumbnail'])){
							$b_hasthumb = true;
							echo '<img src="'.$site_config['site_url']->value.$image_versions['thumbnail'][2].'" />'.$media->name;
						}
					}

					if (!$b_hasthumb) {
						echo '<a href="'.$site_config['site_url']->value.$media->filename.'" target="_blank">'.$media->name.'</a>';						
					}
				} else {
					echo "<a href='".$site_config['site_url']->value.$media->filename."' target='_blank'>".$media->name."</a>";
				}
				?>
				
			</td>
			<td class="medialibrary-image-status">
				<?php
				if (in_array($media->media_type, $template_vars['types_images'])) {
					$image_versions = $media->image_versions();
					foreach($template_vars['default_image_formats'] as $format) {
						$cls = (isset($image_versions->{$format}))?'alert-success':'alert-danger';
						echo '<span class="alert '.$cls.'">'.$format.'</span>';
					}

					if (!empty($image_versions)) {
						foreach($image_versions as $format => $version_data) {
							if (!in_array($format, $template_vars['default_image_formats'])) {
								echo '<span class="alert alert-success">'.$format.' ('.$version_data[0].'x'.$version_data[1].')</span>';
							}
						}
					}					
				}
				?>
			</td>
			<td class="medialibrary-tags">
				<?php
					foreach($media->tags as $tag)
					{
						if($tag->language_id!=null)
						{
							$img = $site_config["site_url"]->value . "img/flags/" . $tag->language->shortname . ".png";
							echo("<span class='alert alert-info'><img src='$img'/> " . $tag->name . "</span>");
						}else{
							echo("<span class='alert alert-info'>" . $tag->name . "</span>");
						}
					}

				?>
		
			</td>
			<td>
				<a class='btn btn-default' data-toggle='modal' data-target='#modal' href="<?php echo $template_vars['delete_pagelink'].'/'.$media->id; ?>""><?php echo ucfirst(translate("delete")); ?></a><br/>
				<?php if (in_array($media->media_type, $template_vars['types_images'])) { ?>
				<a class='btn btn-default' data-toggle='modal' data-target='#modal' href="<?php echo $template_vars['format_add_pagelink'].'/'.$media->id; ?>""><?php echo ucfirst(translate("format_add")); ?></a><br/>
				<?php } ?>
				<a class='btn btn-default' data-toggle='modal' data-target='#modal' href="<?php echo $template_vars['tag_pagelink'].'/'.$media->id; ?>""><?php echo ucfirst(translate("tags")); ?></a>

				<?php
					if(count($media->versions)>0){
				?>
					<a class='btn btn-default' data-toggle='modal' data-target='#modal' href="<?php echo $template_vars['version_pagelink'].'/'.$media->id; ?>""><?php echo ucfirst(translate("versions")); ?></a>
				<?php
					}
				?>
			</td>
		</tr>
	<?php		
		}
	}
	?>
	</table>
</form>