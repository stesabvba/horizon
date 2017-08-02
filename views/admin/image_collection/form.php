<form class="form-horizontal" role="form" data-toggle="validator" method="POST" action="<?php echo actionlink($template_vars['actionlink'],$active_pagemeta->id); ?>">
	<div class="panel panel-default">
		<div class="panel-heading"><?php echo $template_vars['title']; ?></div>
		<div class="panel-body">			
			<!-- -->			
			<input type="hidden" name="id" value="<?php echo $template_vars['image_collection']->id; ?>" />
			<div class="form-group">
				<label for="firstname" class="col-md-4 control-label"><?php echo ucfirst(translate('name')); ?></label>
				<div class="col-md-6">
					<input name="name" id="name" type="text" class="form-control" value="<?php echo e($template_vars['image_collection']->name); ?>" />
				</div>
			</div>


			<div class="form-group">
				<div class="col-md-6 col-md-offset-4">
				<button type="submit" class="btn btn-primary"><i class="fa fa-btn fa-sign-in"></i><?php echo ucfirst(translate('save')); ?></button>
			</div>
			<!-- -->
		</div>
	</div>
</form>