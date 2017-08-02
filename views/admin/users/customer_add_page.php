<?php
	$user = $template_vars['user'];
	$ajax_refresh = isset($_GET['from']) && ($_GET['from'] == 'user_list')?true:false;	
?>
<form role="form" id='add_customer_form' method="POST" action="<?php echo actionlink($template_vars['actionlink'],$active_pagemeta->id); ?>">
	<div class="modal-header">
		<h3><?php echo $globals['active_pagemeta']->title; ?></h3>
	</div>
	<div class="modal-body">
		<input type="hidden" name="user_id" value="<?php echo $template_vars['user']->id; ?>"> 

		<div class="form-group">
			<label for="customer_id" class="control-label"><?php echo ucfirst(translate('customer')); ?></label>
			<select name="customer_id[]" id="customer_id" class="form-control" multiple="multiple">
				<option value="0"></option>
				<?php

					foreach($user->customers as $customer)
					{
						$department_type = $customer->department->departmenttype->name;
						echo("<option value='" . $customer->id . "' selected>" . $customer->number . " - " . $customer->department->company->name ." (" . $department_type . ")</option>");
					}

				?>
			</select>
		</div>
	</div>

	<div class="modal-footer">
		<?php
		$button_type = $ajax_refresh?'button':'submit';
		?>
		<button type="<?php echo $button_type; ?>" id='btn_add' class="btn btn-primary"><?php echo ucfirst(translate("save")); ?></button>
		<button type="button" class="btn btn-secondary" data-dismiss='modal'><?php echo ucfirst(translate("close")); ?></button>
	</div>
</form>



<?php
$url_ajax = $site_config['site_url']->value.'nl/beheer/gebruikers/user_customer_add/klant_zoeken';

$script.="

$(function () {
	";
	if ($ajax_refresh) {
		$script .= "
		$('#btn_add').on('click',function(){
			var postdata = $('#add_customer_form').serialize();

			$.ajax({
			type: 'POST',
			url: '" . actionlink($template_vars['actionlink'],$active_pagemeta->id) . "',
			data: postdata,
			success: function (result){ 
					window.parent.users.getuserlist(window.parent.url);
					$('#modal').modal('hide');
				}
			});

		});
		";
	}
	$script .= "
	
	$('#customer_id').select2({
		multiple: true,
		ajax: {
		    url: '".$url_ajax."',
		    dataType: 'json',
		    delay: 500,
		    method: 'GET',

		    data: function (params) {
		      return {
		        q: params.term, // search term
		        page: params.page
		      };
		    },
		    processResults: function (data, params) {
		      // parse the results into the format expected by Select2
		      // since we are using custom formatting functions we do not need to
		      // alter the remote JSON data, except to indicate that infinite
		      // scrolling can be used
		      params.page = params.page || 1;

		      return {
		        results: data.items,
		        pagination: {
		          more: (params.page * 30) < data.total_count
		        }
		      };
		    },
		    cache: true
		}

	    

	});

	$('#customer_id').focus();

});
	";
?>