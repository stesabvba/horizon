<h1 class="page-title"><?php echo ucfirst(translate('forgot_your_password_pagetitle')); ?></h1>

<p><?php echo ucfirst(translate('reset_your_password', 2)); ?></p>

<div class="row">
	<div class="col-md-8">
		<form class="form-horizontal" method="POST" action="<?php echo $template_vars['post_url']; ?>">
			<div class="form-group <?php echo $validator->addErrorClass('email', $template_vars['validation_errors']); ?>">
				<label for="email" class="col-sm-3 control-label"><?php echo ucfirst(translate('email')); ?><em>*</em></label>
				<div class="col-sm-9">
					<input type="text" class="form-control" name="request_pw[email]" id="email" placeholder="<?php echo $template_vars['labels']['email']; ?>" value="<?php echo e($template_vars['postback']['email']); ?>">
					<?php echo $validator->getError('email', $template_vars['validation_errors']); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-9">
				<button type="submit" class="btn btn-diaz"><?php echo ucfirst(translate('request_password_page_btn_request')); ?></button>
				</div>
			</div>
		</form>
	</div>
</div>