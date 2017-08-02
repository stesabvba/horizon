<?php
$msg_helper->show('messages', -1);
?>
<div class="alert alert-info">
	Hier vindt u de promoted posts voor een pagina 
</div>
<div class="col-md-12">
	<form class="form-horizontal" method="GET">
		<div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label"><?php echo ucfirst(translate('page')); ?>:</label>
		    <div class="col-sm-10">
		      	<select name="page_id" id="page_id" class="form-control select2">
		      		<option value="0"></option>
		      		<?php
		      		if (!empty($template_vars['pages'])) {
		      			foreach($template_vars['pages'] as $page) {
		      				$str_sel = ($page->id == $template_vars['page_id'])?' selected="selected" ':'';
		      				echo '<option value="'.$page->id.'" '.$str_sel.'>'.$page->reference.' ('.$page->id.')</option>';
		      			}
		      		}
		      		?>
				</select>
		    </div>
		  </div>
	</form>

	<?php
	if (!empty($template_vars['page_id'])) {
	?>
	<form class="form-horizontal" method="post" action="<?php echo $template_vars['url_add_page_post']; ?>">
		<input type="hidden" name="page_id" value="<?php echo $template_vars['page_id']; ?>" />
		<div class="form-group">
			<label class="col-sm-2 control-label"><?php echo ucfirst(translate('post')); ?>:</label>
			<div class="col-sm-10">
				<select name="post_id" class="form-control select2">
				<?php
				if (!empty($template_vars['posts'])) {
					foreach($template_vars['posts'] as $post) {
						$str_sel = '';
						echo '<option value="'.$post->id.'" '.$str_sel.'>'.$post->reference.' ('.$post->id.')</option>';
					}
				}
				?>
				</select>
			</div>			
		</div>
		<div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" name="add_post" class="btn btn-add"><?php echo ucfirst(translate('add')); ?></button>
		    </div>
		  </div>
	</form>
	<div class="alert alert-info">
		<?php echo ucfirst(translate('drag_and_drop_the_items_to_change_the_sorting_order')); ?>
	</div>
	<?php
	}

	if (!empty($template_vars['page_posts'])) {
		echo '<ul id="page_posts_list" class="reorder_list">';
			foreach($template_vars['page_posts'] as $post) {
				echo '<li id="sortable_'.$post->id.'" class="pointer">';
					echo '<div class="row">';
						echo '<div class="col-sm-1">';
							echo $post->presentation_order;
						echo '</div>';
						echo '<div class="col-sm-9">';					
							echo '<span class="page_posts_title">'.$post->title($language_id).' ('.$post->id.')</span>';
						echo '</div>';	
						echo '<div class="col-sm-2">';					
							echo '<a class="btn btn-warning btn-danger btn-delete" href="'.$template_vars['url_unlink_page_post'].'?page_id='.$template_vars['page_id'].'&post_id='.$post->id.'" data-toggle="modal" data-target="#modal">'.ucfirst(translate('delete')).'</a>';
						echo '</div>';
					echo '</div>';
				echo '</li>';
			}
		echo '</ul>';
	}
	?>
</div>