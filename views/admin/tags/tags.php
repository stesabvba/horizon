<?php

	$tags = $template_vars['tags'];
	$tag_add_pagelink = $template_vars['tag_add_pagelink'];
	$tag_edit_pagelink = $template_vars['tag_edit_pagelink'];
	$tag_delete_pagelink = $template_vars['tag_delete_pagelink'];

?>
<div class="row">
	<div class="col-md-12">

		<a href='<?php echo($tag_add_pagelink);?>' class='btn btn-default' data-toggle='modal' data-target='#modal'><?php echo(ucfirst(translate('add'))); ?></a>
		<table class='table'>
			
			<thead>
				<tr>
					<th><?php echo(ucfirst(translate('language'))); ?></th>
					<th><?php echo(ucfirst(translate('name'))); ?></th>
					<th><?php echo(ucfirst(translate('edit'))); ?></th>
					<th><?php echo(ucfirst(translate('delete'))); ?></th>
				</tr>

				<?php
					foreach($tags as $tag)
					{

						echo('<tr>');
						if($tag->language_id!=null){
							echo("<td>" . $tag->language->shortname . "</td>");
						}else{
							echo("<td></td>");
						}
						
						echo("<td>" . $tag->name . "</td>");
						echo("<td><a href='" . $tag_edit_pagelink . '/' . $tag->id ."' class='btn btn-default' data-toggle='modal' data-target='#modal'>" . ucfirst(translate('edit')) ."</a></td>");
						echo("<td><a href='" . $tag_delete_pagelink . '/' . $tag->id ."' class='btn btn-default' data-toggle='modal' data-target='#modal'>" . ucfirst(translate('delete')) ."</a></td>");
						echo('</tr>');
					}

				?>
			</thead>

		</table>


	</div>

</div>