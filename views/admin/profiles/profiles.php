<div class="row" id="row-overview-actions">
	<div class="col-md-12">
		<a class="btn btn-default btn-add pull-right" href="<?php echo pagelink('profile_add',$language_id); ?>"><?php echo ucfirst(translate('profile_add')); ?></a>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo ucfirst(translate('profiles')); ?></div>
			<div class='panel-body'>

				<!-- <div class="col-md-6">
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
					
				</div> -->

				<div id='profiles_list'>
					<table class='table'>
					<tr>
						<th width="50"><?php echo translate("id"); ?></th>
						<th><?php echo translate("name"); ?></th>
						<th width="50"><?php echo translate("enduser"); ?></th>
						<th width="50"><?php echo translate("active"); ?></th>
						<th><?php echo translate("copy"); ?></th>
						<th><?php echo translate("edit"); ?></th>
						<th><?php echo translate("delete"); ?></th>
					</tr>
					<?php
					if (!empty($template_vars['profiles'])) {
						foreach($template_vars['profiles'] as $profile){
					?>
						<tr>
						<td><?php echo $profile->id; ?></td>
						<td><?php echo $profile->name; ?></td>
						<td><?php echo $profile->enduser; ?></td>
						<td><?php echo $profile->active; ?></td>

						<td class="action">
							<a class="btn btn-default" href="<?php echo $template_vars['pagelink_copy'].'/'.$profile->id; ?>"><?php echo translate("copy");?></a>
						</td>

						<td class="action">
							<a class="btn btn-default btn-edit" href="<?php echo $template_vars['pagelink_edit'].'/'.$profile->id; ?>"><?php echo  translate("edit"); ?></a>
						</td>
						<td class="action">
							<a class="btn btn-warning btn-danger btn-delete" href="<?php echo $template_vars['pagelink_delete'].'/'.$profile->id; ?>"><?php echo  translate("delete"); ?></a>
						</td>
						</tr>
					<?php
						}
					}
					?>
					</table>
				</div>

			</div>
		</div>
	</div>
</div>
