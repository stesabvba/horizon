
$( document ).ready(function() {


  var admin_menus = 
  {
    init: function()
    {
      
      $('#search').on('keyup',_.debounce(function(){
        
        admin_menus.get_list(config.globals.overview_list_url);

      }, 1000, false));

      $('#menus_list').on('click','.paginationlink',function(e){
        e.preventDefault();
        admin_menus.get_list($(this).attr('href'));
      });

      console.log('admin_menus loaded');

      admin_menus.get_list(config.globals.overview_list_url);
    },
    get_list: function(url)
    {
      var postdata="search=" + $('#search').val();
      $.ajax({
        type: 'POST',
        url: url,
        data: postdata,
        success: function (result){ 
          $('#menus_list').html(result);  
        }
      });
    }


  };


  
  $.when(config.load()).done(admin_menus.init);  

});
