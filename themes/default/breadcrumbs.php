<div class='row'>
	<div class="col-sm-8">
		<ul class='breadcrumb'>
			<?php
				echo $breadcrumb;
			?>
		</ul>
	</div>
	<div class="col-sm-4 text-right">
		<?php if($logged_in == 1){ ?>
			<a id="url_login" href="<?php echo pagelink('logout',$language_id); ?>"><?php echo($active_user->username) . " - " . translate('logout'); ?></a>
		<?php }else{ ?>
			<a id="url_logout" href="<?php echo pagelink('login',$language_id); ?>"><?php echo(ucfirst(translate('login'))); ?></a>
		<?php } ?>
	</div>
</div>