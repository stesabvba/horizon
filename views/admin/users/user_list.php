<?php
	$paginator = $template_vars["paginator"];
	echo($paginator); 

	$can_edit=$active_user->can('view_user_edit_page');
	$can_delete=$active_user->can('view_user_delete_page');

	
?>

<table class='table'>
	<th><?php echo ucfirst(translate("id")); ?></th>
	<th><?php echo ucfirst(translate("firstname")); ?></th>
	<th><?php echo ucfirst(translate("lastname")); ?></th>
	<th><?php echo ucfirst(translate("email")); ?></th>
	<th><?php echo ucfirst(translate("company")); ?></th>
	<th><?php echo ucfirst(translate("profile")); ?></th>
	<th><?php echo ucfirst(translate("active")); ?></th>
	<th><?php echo ucfirst(translate("lastloggedin_at")); ?></th>
	<th><?php echo ucfirst(translate("linked_customers")); ?></th>
	<?php
	if($can_edit)
	{
	?><th><?php echo ucfirst(translate("edit")); ?></th><?php
	}
	?>
	<?php
	if($can_delete)
	{
	?><th><?php echo ucfirst(translate("delete")); ?></th><?php
	}
	?>
</tr>
<?php
foreach($template_vars['users'] as $user){
?>	
	<tr>
	<td><?php echo $user->id; ?></td>
	<td><?php echo $user->firstname; ?></td>
	<td><?php echo $user->lastname; ?></td>
	<td><?php echo $user->email; ?></td>
	<td><?php echo $user->company; ?></td>
	<td><?php echo $user->profile->name; ?></td>
	<td><?php echo $user->active; ?></td>
	<td><?php echo $user->lastloggedin_at; ?></td>
	<?php
		$customer_count = count($user->customers);

	?>
	<td>
		<?php 

			if($customer_count==0){ 
				echo("<p class='alert alert-info'>" . translate('no_customers_found') . "</p>");
			}else{
				foreach($user->customers as $customer)
				{
					if($customer->is_archived == 1)
					{
						echo("<p class='alert alert-danger'>" . $customer->number . " - " . $customer->department->company->name . " (" . $customer->department->departmenttype->name . ") </p>");
					}else if($customer->is_archived!=1 && $customer->order_entry_not_allowed==1)
					{
						echo("<p class='alert alert-warning'>" . $customer->number . " - " . $customer->department->company->name . " (" . $customer->department->departmenttype->name . ") </p>");

					}else{
						echo("<p class='alert alert-success'>" . $customer->number . " - " . $customer->department->company->name . " (" . $customer->department->departmenttype->name . ") </p>");
					}
		
				}
			}
			
			$user_customer_add_pagelink = pagelink('user_customer_add',$language_id) . "/" . $user->id.'?from=user_list';
		?>

		<a href='<?php echo($user_customer_add_pagelink); ?>' class='btn btn-default' data-toggle='modal' data-target='#modal'><?php echo(ucfirst(translate('edit'))); ?></a>
	</td>
	<?php if($can_edit)
		{
	?>

	<td><a class='btn btn-default btn-edit' href="<?php echo $template_vars['pagelink_edit'].'/'.$user->id; ?>"><?php echo ucfirst(translate("edit")); ?></a></td>
	<?php
		}
	?>


	<?php if($can_delete)
		{
	?>
	<td><a class='btn btn-default btn-delete' data-toggle='modal' data-target='#modal' href="<?php echo $template_vars['pagelink_delete'].'/'.$user->id; ?>"><?php echo ucfirst(translate("delete")); ?></a></td>

	</tr>

	<?php
		}
	?>

<?php	
}
?>
</table>