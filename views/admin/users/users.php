<div class="row" id="row-overview-actions">
	<div class="col-md-12">
		<?php
			if($active_user->can('view_link_customers_page'))
			{
		?>
			<a class='btn btn-default btn-add pull-right' href="<?php echo $template_vars['pagelink_user_customerlink']; ?>"><?php echo ucfirst(translate('link_customers')); ?></a>
		<?php
			}
		?>
		<?php

			if($active_user->can('view_user_add_page'))
			{
		?>
		<a class='btn btn-default btn-add pull-right' href="<?php echo $template_vars['pagelink_useradd']; ?>"><?php echo ucfirst(translate('user_add')); ?></a>
		<?php
			}
		?>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo ucfirst(translate('users')); ?></div>
			<div class='panel-body'>

			<div class="col-md-6">
				<div class="form-group">
					<label for='user_linktype'>Filter:</label>
					<select name='user_linktype' id='user_linktype' class='form-control'>
						<option value='1'><?php echo(ucfirst(translate('all_users'))); ?></option>
						<option value='2'><?php echo(ucfirst(translate('users_who_are_linked_to_a_customer'))); ?></option>
						<option value='4'><?php echo(ucfirst(translate('users_who_are_linked_to_a_disabled_customer'))); ?></option>
						<option value='3'><?php echo(ucfirst(translate('users_who_are_not_linked_to_a_customer'))); ?></option>
					</select>

				</div>
			</div>
			
			<div class="col-md-6 ">
				<div class="form-group">
					<label for='search'>Zoeken:</label>
					<input type='text' name='search' id='search' class='form-control'/>
				</div>
				
			</div>

			<div id='user_list'>

			</div>

			</div>
		</div>
	</div>
</div>