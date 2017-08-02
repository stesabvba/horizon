<?php
	$translations = $template_vars['translations'];
	$paginator = $template_vars['paginator'];


?>
<div class="col-md-8">
	<?php echo($paginator); ?>
</div>


<div class="col-md-4">
	<?php echo($translations->total() . ' '. translate('translations_found')); ?>
</div>
<table id='translations' class='table table-striped'>
	<thead>
		<tr>
		<th><?php echo ucfirst(translate("id")); ?></th>
		<th><?php echo ucfirst(translate("reference")); ?></th>
		<th><?php echo ucfirst(translate("language")); ?></th>
		<th><?php echo ucfirst(translate("needs_review")); ?></th>
		<th><?php echo ucfirst(translate("type")); ?></th>
		<th><?php echo ucfirst(translate("translation")); ?></th>
		<th><?php echo ucfirst(translate("edit")); ?></th>
		<th><?php echo ucfirst(translate("delete")); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		if (!empty($translations)) {
			foreach($translations as $trans) {
		?>
		<tr>
			<td><?php echo $trans->id; ?></td>
			<td><?php echo $trans->reference; ?></td>
			<td><?php echo $trans->language->shortname; ?></td>
			<td><?php echo YesNo($trans->unstable); ?></td>
			<td><?php echo $trans->type; ?></td>
			<td><?php echo $trans->translation; ?></td>
			<td class="action">
				<a class="btn btn-default btn-edit" data-toggle="modal" data-target="#modal"  href="<?php echo $template_vars['editpagelink'].'/'.$trans->id; ?>"><?php echo ucfirst(translate('edit')); ?></a>
			</td>
			<td class="action">
				<a class="btn btn-warning btn-danger btn-delete" data-toggle="modal" data-target="#modal" href="<?php echo $template_vars['deletepagelink'].'/'.$trans->id; ?>"><?php echo ucfirst(translate('delete')); ?></a>
			</td>
		</tr>
		<?php
			}
		}
		?>
	</tbody>
</table>

<!-- $data_columns = "{'name': 'id', 'data': 'id'},{'name': 'reference', 'data': 'reference'},{'name': 'language_id', data: 'language', 'searchable':false},{name: 'type', 'data': 'type'},{'name':'translation', 'data': 'translation'},{'data': 'editlink', 'searchable': false, 'orderable': false},{'data': 'deletelink', 'searchable': false, 'orderable': false }
$script.=Paginate("translations",actionlink('TranslationController@translations_list',$active_pagemeta->id),$data_columns -->
