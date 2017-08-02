<?php

	$page_meta_id = $template_vars["page_meta_id"];
	$tags = $template_vars["tags"];

	function get_tags($parent_id, $page_meta_id)
	{
		$ptags = TagParents::where('parent_id',$parent_id)->where('page_meta_id',$page_meta_id)->orderBy('presentation_order')->get();

		echo("<ol id='ptag_list_" . $parent_id . "' class='dd_list'>");


		foreach($ptags as $ptag){

			//echo("<li id='ptag_" . $ptag->id . "' class='ptag dd-item' data-id='" . $ptag->id . "'><div class='dd-handle'>" . $ptag->tag->name . " <a id='delete_ptag_" . $ptag->id . "' class='delete_ptag btn btn-default'><i class='fa fa-trash-o' aria-hidden='true'></i></a></div>");

			echo("<li id='ptag_" . $ptag->id . "' class='ptag dd-item' data-id='" . $ptag->id . "'><div class='dd-handle'>" . $ptag->tag->name . "</div>");


			get_tags($ptag->id,$page_meta_id);

			echo("</li>");
		}

		echo("</ol>");
	}

?>
<div class="row">

		<div class="dd col-md-6">
		<?php get_tags(0,$page_meta_id); ?>
		</div>


	<div class="col-md-6">
	
	<ul id='tag_list'>
				<?php

					foreach($tags as $tag)
					{
						if($tag->language!=null)
						{
							echo("<li id='tag_" . $tag->id . "'>" . $tag->name . "(" . $tag->language->shortname . ")</li>");
						}else{
							echo("<li id='tag_" . $tag->id . "'>" . $tag->name . "</li>");
						}
						

					}

				?>

	</ul>


	</div>
</div>