<div class="row">
	<div class="col-md-12">
	
	<div class="col-md-8">
		<?php if($active_user->can("view_page_add_page")) { ?>
		<a class='btn btn-default' href='<?php echo(pagelink('page_add',$language_id)); ?>'><?php echo(ucfirst(translate('page_add')));?></a>
		<?php } ?>
	</div>


	
	<div class="col-md-4">
		<div class="form-group">
			<label for='search'>Zoeken:</label>
			<input type='text' name='search' id='search' class='form-control'/>

		</div>
		
	</div>
	

	</div>

	

	<div id="page_list">
		

	</div>
</div>

