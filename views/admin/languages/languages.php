<div class="row" id="row-overview-actions">
	<div class="col-md-12">
		<a class="btn btn-default btn-add pull-right" href="<?php echo pagelink('language_add',$language_id); ?>"><?php echo ucfirst(translate('language_add')); ?></a>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo ucfirst(translate('languages')); ?></div>
			<div class='panel-body'>
				<!-- <div class="col-md-6">
				</div>
				
				<div class="col-md-6 ">
					<div class="form-group">
						<label for='search'>Zoeken:</label>
						<input type='text' name='search' id='search' class='form-control'/>
					</div>
				</div> -->
				<div id="languages_list">
					<table class="table">
						<th width="50"><?php echo ucfirst(translate("id")); ?></th>
						<th><?php echo ucfirst(translate("name")); ?></th>
						<th width="100"><?php echo ucfirst(translate("shortname")); ?></th>
						<th width="50"><?php echo ucfirst(translate("active")); ?></th>
						<th><?php echo ucfirst(translate("edit")); ?></th>
						<th><?php echo ucfirst(translate("delete")); ?></th>
					</tr>

					<?php 
					foreach($template_vars['languages'] as $language){
						?>	
						<tr>
							<td><?php echo $language->id; ?></td>
							<td><?php echo $language->name; ?></td>
							<td><?php echo $language->shortname; ?></td>
							<td><?php echo $language->active; ?></td>

							<td class="action">
								<a class='btn btn-default btn-edit' href="<?php echo $template_vars['pagelink_edit'].'/'.$language->id; ?>"><?php echo ucfirst(translate("edit")); ?></a>
							</td>
							<td class="action">
								<a class='btn btn-warning btn-danger btn-delete' href="<?php echo $template_vars['pagelink_delete'].'/'.$language->id; ?>"><?php echo ucfirst(translate("delete")); ?></a>
							</td>

						</tr>
						<?php
					}
					?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>