var admin_mails;
var url;

$( document ).ready(function() {


  admin_mails = 
  {
    init: function()
    {
      url = config.globals.url_overview_ajax;

      $('#search').on('keyup',_.debounce(function(){
        admin_mails.get_dealerlist(config.globals.url_overview_ajax);
      }, 1000, false));

      $('#visibility').on('change',function(){
        admin_mails.get_dealerlist(config.globals.url_overview_ajax);
      });

      $('#mails_list').on('click','.paginationlink',function(e){
        e.preventDefault();
        admin_mails.get_dealerlist($(this).attr('href'));
      });

      console.log('admin_mails loaded');

      admin_mails.get_dealerlist(config.globals.url_overview_ajax);
    },
    get_dealerlist: function(url)
    {
      var postdata="search=" + $('#search').val() + "&visibility=" + $("#visibility").val();

      $.ajax({
        type: 'POST',
        url: url,
        data: postdata,
        success: function (result){ 
          //console.log(result);
          $('#mails_list').html(result);  
        }
      });
    }


  };


  
  $.when(config.load()).done(admin_mails.init);  

});
