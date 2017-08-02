<h1 class="page-title"><?php echo ucfirst(translate('forgot_your_password_pagetitle')); ?></h1>

<p>
<?php
if (is_null($template_vars['user'])) {
	echo ucfirst(translate('request_password_reset_no_user_found', 2)); 
	return;
} else {
	echo ucfirst(translate('request_password_reset_text', 2));
}
?>
</p>

<div class="row">
	<div class="col-md-8">
		<form class="form-horizontal" method="POST" action="<?php echo $template_vars['post_url']; ?>">
			<div class="form-group <?php echo $validator->addErrorClass('password', $template_vars['validation_errors']); ?>">
				<label for="inputPassword" class="col-sm-3 control-label"><?php echo $template_vars['labels']['password']; ?><em>*</em></label>
				<div class="col-sm-9">
					<input type="password" class="form-control" name="request_password_reset_page[password]" id="inputPassword" placeholder="<?php echo $template_vars['labels']['password']; ?>">
				</div>
			</div>
			<div class="form-group <?php echo $validator->addErrorClass('password', $template_vars['validation_errors']); ?>">
				<label for="inputPassword" class="col-sm-3 control-label"><?php echo $template_vars['labels']['password2']; ?><em>*</em></label>
				<div class="col-sm-9">
					<input type="password" class="form-control" name="request_password_reset_page[password2]" id="inputPassword" placeholder="<?php echo $template_vars['labels']['password2']; ?>">
					<span class="help-block"><?php echo ucfirst(translate('password_needs_to_be_four_characters_minimum')); ?></span>
					<?php echo $validator->getError('password', $template_vars['validation_errors']); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9">
				<button type="submit" class="btn btn-diaz"><?php echo ucfirst(translate('change_password')); ?></button>
				</div>
			</div>
		</form>
	</div>
</div>