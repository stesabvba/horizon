<?php

	$tags = $template_vars['tags'];
?>
<div id='dropzone'>

	<h3>Drop files here!</h3>
	<div class="row">
		<div class="col-md-6">
			<div class='form-group'>
				<label for='tags' class='control-label'>Tags:</label>
				<select id='tags' name='tags' multiple="multiple" class='form-control select2'>
					<?php
						foreach($tags as $tag)
						{
							if($tag->language_id!=null)
							{
								echo("<option value='" . $tag->id . "'>" . $tag->language->shortname . " | " . $tag->name . "</option>");
							}else{
								echo("<option value='" . $tag->id . "'>" . $tag->name . "</option>");
							}
							
						}
					?>
				</select>
			</div>
		</div>
	</div>
	

	<p id='uploading_files' style='display: none;'><i class='fa fa-refresh fa-spin'></i> Uploading files</p>

	<div id='files'>
	
	</div>

	


</div>

<div class="row">
	
		<div class="col-md-6">
		<div class="form-group">
			<label for='search'>Zoeken op naam:</label>
			<input type='text' name='search' id='search' class='form-control'/>

		</div>

		</div>
		<div class="col-md-6">
			<div class='form-group'>
				<label for='tags' class='control-label'>Zoeken op tags:</label>
				<select id='search_tags' name='search_tags' multiple="multiple" class='form-control select2'>
					<?php
						foreach($tags as $tag)
						{
							if($tag->language_id!=null)
							{
								echo("<option value='" . $tag->id . "'>" . $tag->language->shortname . " | " . $tag->name . "</option>");
							}else{
								echo("<option value='" . $tag->id . "'>" . $tag->name . "</option>");
							}
							
						}
					?>
				</select>
			</div>
		</div>
		

	
</div>


<div id='medialist'>

</div>



