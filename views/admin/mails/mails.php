<div class="row" id="row-overview-actions">
	<div class="col-md-12">
		<a class='btn btn-default btn-add pull-right' href="<?php echo pagelink('mail_add',$language_id); ?>"><?php echo ucfirst(translate('mail_add')); ?></a>
		<a class='btn btn-default btn-add pull-right' href="<?php echo pagelink('mail_templates',$language_id); ?>"><?php echo ucfirst(translate('mail_templates')); ?></a>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading"><?php echo ucfirst(translate('mails')); ?></div>
			<div class='panel-body'>
				<div class="col-md-6">
				</div>
				
				<div class="col-md-6 ">
					<div class="form-group">
						<label for='search'>Zoeken:</label>
						<input type='text' name='search' id='search' class='form-control'/>
					</div>
				</div>
				<div id="mails_list">					
				</div>
			</div>
		</div>
	</div>
</div>

