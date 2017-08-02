<?php
$breadcrumb.=generatePageBreadCrumb('home');
$breadcrumb.=generatePageBreadCrumb('manage');
$breadcrumb.=generatePageBreadCrumb('users');
$breadcrumb.=generatePageBreadCrumb('user_edit',array($template_vars['user']->id));
?>
<form id='order' class='form-horizontal' role='form' data-toggle='validator' method='POST'>
	<?php
	include('tabs.php');
	?>

	<div class="panel panel-default">
		<div class="panel-heading">
			<?php echo ucfirst(translate('user_edit')); ?>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-md-12">
					<?php echo ucfirst(translate('user')); ?>: <?php echo $template_vars['user']->firstname.' '.$template_vars['user']->lastname.' ('.$template_vars['user']->id.')'; ?>
				</div>
			</div>

			<div class="row" id="row-overview-actions">
				<div class="col-md-12">
					<?php
						if($active_user->can('view_user_customer_add_page'))
						{
					?>
					<a href="<?Php echo $template_vars['customer_add_link']; ?>"" class='btn btn-default btn-add pull-right' data-toggle='modal' data-target='#modal'><?php echo ucfirst(translate('add')); ?></a>

					<?php
						}
					?>
					
				</div>
			</div>			
			<?php
			if (!is_null($template_vars['customers'])) {
			?>
			<table class='table'>
				<tr>
					<th><?php echo ucfirst(translate('id')); ?></th>
					<th><?php echo ucfirst(translate('name')); ?></th>
					<th><?php echo ucfirst(translate('address')); ?></th>
					<th><?php echo ucfirst(translate('postal_code')); ?></th>
					<th><?php echo ucfirst(translate('city')); ?></th>
					<th><?php echo ucfirst(translate('department')); ?></th>
					<th class="action"><?php echo ucfirst(translate('delete')); ?></th>
				</tr>
			<?php
				foreach($template_vars['customers'] as $cust) {
			?>
			<tr>
				<td><?php echo $cust->customer_id; ?></td>
				<td><?php echo $cust->name; ?></td>
				<td><?php echo $cust->address; ?></td>
				<td><?php echo $cust->postal_code; ?></td>
				<td><?php echo $cust->city; ?></td>
				<td><?php echo $cust->department_type_name; ?></td>
				<?php
					if($active_user->can('view_user_customer_delete_page'))
					{
				?>
<td class="action"><a href="<?php echo $template_vars['customer_delete_link'].'/'.$template_vars['user']->id.'/'.$cust->customer_id; ?>" data-toggle='modal' data-target='#modal' class='btn btn-danger btn-delete'><?php echo ucfirst(translate('delete')); ?></a></td>
				<?php
					}
				?>
				
			</tr>
			<?php
				}
			?>
			</table>
			<?php
			}
			?>
		</div>
	</div>
</form>