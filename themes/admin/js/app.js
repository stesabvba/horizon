$(document).ready(function() {

	var app = {
		init: function() {
			console.log('app initialized');


			$('.select2').select2({
				allowClear: true,
			});

			tinymce.init({
				selector: '.wysiwyg',
				height:400,
				plugins: "code link paste",
				paste_as_text: true,
				relative_urls: false,				
				remove_script_host: false,
				menubar: "file edit insert view format table tools insert",
				toolbar: "code | undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link",

				force_br_newlines : false,
      			force_p_newlines : false,
      			forced_root_block : '',
			});
	
		}
	}

	$.when(config.load()).done(app.init);
});