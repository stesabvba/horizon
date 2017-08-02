<?php echo $content; ?>



<?php

	$html_helper->writeScripts();
?>
<script type="text/javascript">
			var config_modal = {
				globals: {},
				url_get: '<?php echo $site_config['site_url']->value.$globals['language']->shortname.'/js_config_get'; ?>',
				load: function() {
					var self = this;
					var deferred = new $.Deferred();
					$.ajax({
						url: self.url_get,
						method:'POST',
						dataType: 'json',
						cache: false,				
					}).done(function(json_data) {
						
						config_modal.globals = json_data;
						<?php $html_helper->writeJsVars('config_modal'); ?>
						deferred.resolve("config load Completed");	
					});
					return deferred.promise();
				}			
			}



</script>
<script>

	$(document).ready(function() {
/*	tinymce.init({
		selector: 'wysiwyg',
		height:150,
		plugins: "template code link",
		relative_urls: false,
		remove_script_host: false,
		menubar: "file edit insert view format table tools insert",
		toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link",
		setup: function (editor) {
        editor.on('change', function () {
            editor.save();
        });},
		force_br_newlines : false,
		force_p_newlines : true,
		forced_root_block : '',
	});*/

	$('.select2').select2();
	
	});

	<?php echo $script;	?>
	
</script>
