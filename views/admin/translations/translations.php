<div class="row" id="row-overview-actions">
	<div class="col-md-8">
		<a class="btn btn-default btn-add pull-right" href="<?php echo pagelink('translation_add',$language_id); ?>"><?php echo ucfirst(translate('translation_add')); ?></a>
	</div>

	<div class="col-md-4">
		<a class='btn btn-default' href='<?php echo(pagelink('translations',$language_id,'GET','TranslationController@toggle_inline_translations')); ?>'><?php echo(ucfirst(translate('toggle_inline_translations'))); ?></a>
	</div>

</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo ucfirst(translate('translations')); ?></div>
			<div class='panel-body'>

				<div class="col-md-6">
					<div class="form-group">
						<label for='translation_type'>Type vertaling:</label>
						<select name='translation_type' id='translation_type' class='form-control'>
							<option value='1'><?php echo(ucfirst(translate('all_translations'))); ?></option>
							<option value='2'><?php echo(ucfirst(translate('translations_that_need_review'))); ?></option>
							<option value='3'><?php echo(ucfirst(translate('translations_that_are_reviewed'))); ?></option>
						</select>

					</div>
				</div>
				
				<div class="col-md-6 ">
					<div class="form-group">
						<label for='search'>Zoeken:</label>
						<input type='text' name='search' id='search' class='form-control'/>

					</div>
					
				</div>

				<div id='translations_list'>

				</div>

			</div>
		</div>
	</div>
</div>