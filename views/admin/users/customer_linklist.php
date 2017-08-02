<style type="text/css">
.frm-link-customer {
}

.table-link-customer {
	font-size:10px;
	background-color:#efefef;
	border-bottom: solid 1px #000;
}
</style>

<?php 
if ($template_vars['pager'] !== false) {
	echo $template_vars['pager']; 
}
?>

<div class="row" id="row-overview-actions">
	<div class="col-md-12">
		<a class='btn btn-default btn-add pull-right' href="<?php echo $template_vars['actionlink']; ?>"><?php echo ucfirst(translate('link_customers')); ?></a>
	</div>
</div>

<table class='table'>
	<th><?php echo ucfirst(translate("id")); ?></th>
	<th><?php echo ucfirst(translate("firstname")); ?></th>
	<th><?php echo ucfirst(translate("lastname")); ?></th>
	<th><?php echo ucfirst(translate("email")); ?></th>
	<th><?php echo ucfirst(translate("username")); ?></th>
	<th><?php echo ucfirst(translate("profile")); ?></th>
	<th><?php echo ucfirst(translate("active")); ?></th>
	<th><?php echo ucfirst(translate("add")); ?></th>
</tr>
<?php
if (!empty($template_vars['users'])) {
	foreach($template_vars['users'] as $user) {
?>
<tr>
	<td>
		<a name="user<?php echo $user->id; ?>"><?php echo $user->id; ?></a>
	</td>
	<td><?php echo $user->firstname; ?></td>
	<td><?php echo $user->lastname; ?></td>
	<td><?php echo $user->email; ?></td>
	<td><?php echo $user->username; ?></td>
	<td><?php echo $user->profile->name; ?></td>
	<td>
		<?php echo $user->active; ?>
	</td>
</tr>
<tr>
	<td colspan="8" class="table-link-customer">
		<form class="form-inline frm-link-customer" role="form" data-toggle="validator" method="POST" action="<?php echo $template_vars['postlink']; ?>">
			<div class="form-group">
				<input type="hidden" name="user_id" value="<?php echo $user->id; ?>" />
				<select name="customer_id" class="form-control select2">
					<?php
					$ids_current_customers = [];
					$ids_current_customers = $user->customers->pluck('id')->toArray();

					if (!empty($template_vars['departments'])) {
						foreach($template_vars['departments'] as $cust) {
							$str_sel = ($user->customer_voorstel_id == $cust->id)?' selected="selected" ':'';						
							if (!in_array($cust->id, $ids_current_customers)) {
					?>	
						<option value="<?php echo $cust->id; ?>" <?php echo $str_sel; ?>><?php echo $cust->name.' ('.$cust->department_type_label.' '.$cust->id.')'; ?></option>
					<?php
							}
						}
					}
					?>
				</select>
				<button type="submit" class="btn btn-default btn-sm btn-add"><?php echo ucfirst(translate('link')); ?></button>

				<label>
				<?php
				if (!empty($user->customer_voorstel_id)) {
					echo 'Voorstel: '.$user->firma_voorstel.' ('.$user->customer_voorstel_id.') ';
				}
				?>
				</label>
			</div>
			
		</form>		

		<?php
		if ($user->customers->count() > 0) {
		?>
			<table class="table table-bordered">
			<tr>
				<th><?php echo ucfirst(translate("id")); ?></th>
				<th><?php echo ucfirst(translate("department")); ?></th>
				<th class="action"><?php echo ucfirst(translate("delete")); ?></th>
			</tr>
				
		<?php
			foreach($user->customers as $customer) {
		?>
				<tr>
					<td><?php echo $customer->id; ?></td>
					<td>
					<?php 
						if (!is_null($customer->department)) {
							echo $customer->department->name; 

							if (!is_null($customer->department->departmenttype)) {
								echo ' ('.$customer->department->departmenttype->name.')'; 
							}
						}						
					?>						
					</td>
					<td class="action">
						<?php
						$url_unlink = $template_vars['deletelink'].'/'.$user->id.'/'.$customer->id;
						?>
						<a class="btn btn-danger btn-delete btn-xs" data-toggle='modal' data-target='#modal'  href="<?php echo $url_unlink; ?>"><?php echo ucfirst(translate("delete")); ?></a>
					</td>
				</tr>						
		<?php
			}
		?>
			</table>
		<?php
		}
		?>
	</td>
</tr>
<?php			
	}
}
?>
</table>