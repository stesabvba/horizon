if (!window.console) window.console = {};
if (!window.console.log) window.console.log = function () { };

$(document).ready(function() {
	var app = {
		init: function() {
			console.log('app initialized');
			app.initEditors();
			//console.log(config.globals.naam);

			$('select.select2').select2({
				allowClear: true
			});

			$('.searchable').select2({ theme: 'bootstrap', width: '100%',
				templateResult: function (data, container) {
				    if (data.element) {
				      $(container).addClass($(data.element).attr("class"));
				    }
				    return data.text;
				  } });

			$('#dealerdetail-thumbs .afbeelding').matchHeight({byRow :true});

			$(".share_facebook").on("click",function(){
				FB.ui({
				  method: 'share',
				  href: window.location.href ,
				}, function(response){});
			});

		},
		initEditors: function() {
			tinymce.init({
				selector: '.wysiwyg',
				height:400,
				relative_urls: false,
				remove_script_host: false,
				toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
				menubar: false,
				force_br_newlines : true,
      			force_p_newlines : false,
      			forced_root_block : '',
			});

		}
	};

	$.when(config.load()).done(app.init);	
});

<!-- faceBook -->
window.fbAsyncInit = function()
{
   FB.init({
      appId   : '404642416387862',
      xfbml   : true,
      version : 'v2.3'
   });
};

(function(d, s, id)
{
   var js, fjs = d.getElementsByTagName(s)[0];
   if (d.getElementById(id)){ return; }
   js = d.createElement(s);
   js.id = id;
   js.src = "//connect.facebook.net/en_US/sdk.js";
   fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));