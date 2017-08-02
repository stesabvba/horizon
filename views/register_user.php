<h1 class="page-title"><?php echo ucfirst(translate('register_user_pagetitle')); ?></h1>
<div class="row">
  <div class="col-md-8">
    <div id="register_user_intro">
      <p><?php echo translate('register_user_intro', 2); ?></p>
    </div>

    <form class="form-horizontal" method="POST" action="<?php echo $template_vars['post_url']; ?>">
        <div class="form-group <?php echo $validator->addErrorClass('firstname', $template_vars['validation_errors']); ?>">
          <label for="firstname" class="col-sm-3 control-label"><?php echo ucfirst(translate('firstname')); ?><em>*</em></label>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="user[firstname]" id="firstname" placeholder="<?php echo $template_vars['labels']['firstname']; ?>" value="<?php echo e($template_vars['postback']['firstname']); ?>">
          </div>
        </div>
        <div class="form-group <?php echo $validator->addErrorClass('lastname', $template_vars['validation_errors']); ?>">
          <label for="lastname" class="col-sm-3 control-label"><?php echo $template_vars['labels']['lastname']; ?><em>*</em></label>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="user[lastname]" id="lastname" placeholder="<?php echo $template_vars['labels']['lastname']; ?>" value="<?php echo e($template_vars['postback']['lastname']); ?>">
          </div>
        </div>
        <div class="form-group <?php echo $validator->addErrorClass('company', $template_vars['validation_errors']); ?>">
          <label for="company" class="col-sm-3 control-label"><?php echo $template_vars['labels']['company']; ?><em>*</em></label>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="user[company]" id="company" placeholder="<?php echo $template_vars['labels']['company']; ?>" value="<?php echo e($template_vars['postback']['company']); ?>">
          </div>
        </div>
        <div class="form-group <?php echo $validator->addErrorClass('email', $template_vars['validation_errors']); ?>">
          <label for="email" class="col-sm-3 control-label"><?php echo $template_vars['labels']['email']; ?><em>*</em></label>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="user[email]" id="email" placeholder="<?php echo $template_vars['labels']['email']; ?>" value="<?php echo e($template_vars['postback']['email']); ?>">
              <?php echo $validator->getError('email', $template_vars['validation_errors']); ?>
          </div>
        </div>
        <div class="form-group <?php echo $validator->addErrorClass('phone', $template_vars['validation_errors']); ?>">
          <label for="email" class="col-sm-3 control-label"><?php echo $template_vars['labels']['phone']; ?><em>*</em></label>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="user[phone]" id="phone" placeholder="<?php echo $template_vars['labels']['phone']; ?>" value="<?php echo e($template_vars['postback']['phone']); ?>">
          </div>
        </div>
        <div class="form-group <?php echo $validator->addErrorClass('password', $template_vars['validation_errors']); ?>">
          <label for="inputPassword" class="col-sm-3 control-label"><?php echo $template_vars['labels']['password']; ?><em>*</em></label>
          <div class="col-sm-9">
            <input type="password" class="form-control" name="user[password]" id="inputPassword" placeholder="<?php echo $template_vars['labels']['password']; ?>">
          </div>
        </div>
        <div class="form-group <?php echo $validator->addErrorClass('password', $template_vars['validation_errors']); ?>">
          <label for="inputPassword" class="col-sm-3 control-label"><?php echo $template_vars['labels']['password2']; ?><em>*</em></label>
          <div class="col-sm-9">
            <input type="password" class="form-control" name="user[password2]" id="inputPassword" placeholder="<?php echo $template_vars['labels']['password2']; ?>">
            <span class="help-block"><?php echo ucfirst(translate('password_needs_to_be_four_characters_minimum')); ?></span>
            <?php echo $validator->getError('password', $template_vars['validation_errors']); ?>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-9">
            <button type="submit" class="btn btn-diaz"><?php echo ucfirst(translate('register')); ?></button>
          </div>
        </div>
      </form>

      <p><?php echo ucfirst(translate('fields_with_star_are_required')); ?></p>

      <p><a href="<?php echo pagelink('login', $language_id); ?>"><?php echo ucfirst(translate('already_have_an_account_log_in_here')); ?></a></p>

      <p><a href="<?php echo pagelink('forgot_password', $language_id); ?>"><?php echo ucfirst(translate('forgot_your_password')); ?></a></p>

  </div>
</div>