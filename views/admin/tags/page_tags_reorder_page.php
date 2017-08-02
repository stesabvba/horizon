<form role='form' method='post' action="<?php echo actionlink($template_vars['actionlink'],$active_pagemeta->id); ?>">
	<div class="modal-header">
		<h3><?php echo $active_pagemeta->title; ?></h3>
	</div>
	<div class="modal-body">
		<div class="js_vars">
			<input type="hidden" id="url_reorder" value="<?php echo $template_vars['url_reorder']; ?>" />
		</div>
		<?php
		if ($template_vars['tag_parents']->count() > 0) {
			echo '<ul id="page_tags_list" class="reorder_list">';
				foreach($template_vars['tag_parents'] as $tag_parent) {
					$tag = $tag_parent->tag;
					if ($tag != null) {
						//$tag = Tag::find($tag_parent->
						echo '<li id="sortable_'.$tag_parent->id.'" class="pointer">';
							echo '<div class="row">';
								echo '<div class="col-sm-1">';
									echo $tag_parent->presentation_order;
								echo '</div>';
								echo '<div class="col-sm-9">';					
									//echo '<span class="page_posts_title">'.$post->title($language_id).' ('.$post->id.')</span>';
									echo $tag->name;
								echo '</div>';	
							echo '</div>';
						echo '</li>';
					}					
				}
			echo '</ul>';
		}
		?>

	</div>
	<div class="modal-footer">
		<!-- <button type="submit" class="btn btn-danger"><?php echo ucfirst(translate("yes")); ?></button>
		<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo ucfirst(translate("no")); ?></button> -->
		<button type="button" class="btn btn-secondary js_dismiss_reorder" ><?php echo ucfirst(translate("close")); ?></button>
	</div>	
</form>

<script>
$( document ).ready(function() {
	var obj = {
		init: function() {
			config.globals.url_reorder = $('#url_reorder').val();
			$('#page_tags_list').sortable({
				update: obj.updateOrder
			});

			$('.js_dismiss_reorder').on('click', function(event) {
				$('#modal').modal('hide');
				var href = location.href;
              	location.href = href;
			});
		},
		updateOrder: function() {
			$grid = $('#page_tags_list');

	      //console.log('url_reorder='+config.globals.url_reorder);
	      var order = $grid.sortable('serialize');
	      order += '&tag_parents_id='+config.globals.tag_parents_id;
	      console.log(order);

	      $grid.sortable('toArray', {attribute: "data-item"});
	      console.log(order);

	      $.ajax({
	      	url: config.globals.url_reorder,
	      	type:"post",
	      	data:order,
	      	success:function(data) {
					/*console.log(data);
					var href = location.href;
					location.href = href;*/
	           }
	       });
	  }
	};

	$.when(config.load()).done(obj.init);  
});
</script>