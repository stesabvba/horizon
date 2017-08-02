<?php $msg_helper->show('messages', -1); ?>
<div class='row'>
	<div class='col-md-6'>		
		<div class='panel panel-default'>
			<div class='panel-heading'><?php echo ucfirst(translate('login_title')); ?></div>
			<div class='panel-body'>			

				<p><?php echo ucfirst(translate('login_text',TEXT));?> </p>
			
				<form method='post' id='login' class='form-horizontal' action='<?php echo actionlink('HomeController@login',$active_pagemeta->id); ?>'>
					<div class='form-group'>
						<label for='username' class='col-md-4 control-label'><?php echo ucfirst(translate('email')); ?><em>*</em></label>
						<div class='col-md-8'>
							<input name='username' id='username' type='text' class='form-control' required />
						</div>
					</div>
					
					<div class='form-group'>
						<label for='password' class='col-md-4 control-label'><?php echo ucfirst(translate('password')); ?><em>*</em></label>
						<div class='col-md-8'>
							<input name='password' id='password' type='password' class='form-control' required />
						</div>
					</div>

					<div class='form-group'>
						<div class="col-md-8 col-md-offset-4 help-block"><?php echo ucfirst(translate('fields_with_star_are_required')); ?></div>
					</div>		
					
					
					<div class='form-group'>
						<div class='col-md-8 col-md-offset-4'>
							<input type='submit' class='btn btn-diaz' value='<?php echo ucfirst(translate('login')); ?>'/>
						</div>
					</div>										
				</form>			
				<p><a class="reg_optie" href="<?php echo $template_vars['pagelink_register_user']; ?>"><?php echo ucfirst(translate('register')); ?></a></p>

				<p><a class="reg_optie" href="<?php echo $template_vars['pagelink_forgot_your_password']; ?>"><?php echo ucfirst(translate('forgot_your_password')); ?></a></p>
			</div>
		</div>

	</div>
</div>