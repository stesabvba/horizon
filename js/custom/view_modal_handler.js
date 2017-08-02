function handle_inject(url){
	
	var content_type = $("#inject_content_type").val();	
	var content = $("#inject_content").val();
	
	$.post(url, { content_type : content_type, content : content },function(data){
		tinymce.activeEditor.execCommand('mceInsertContent', false, data);$('#modal').modal('hide');
	});
	
	
	
}

