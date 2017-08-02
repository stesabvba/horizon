
$( document ).ready(function() {

  var sortfield="id";
  var sortdirection="asc";

  var pages = 
  {
    init: function()
    {
      
      $('#search').on('keyup',_.debounce(function(){
        
       pages.getpagelist();

      }, 500, false));

      $('#page_list').on('click','.paginationlink',function(e){
        e.preventDefault();
        config.globals.pagelist_url=($(this).attr('href'));
        pages.getpagelist();
      });

      $('#page_list').on('click','.column',function(e){
        e.preventDefault();
        sortfield="reference";

        if(sortdirection=="asc")
        {
          sortdirection="desc";
        }else{
          sortdirection="asc";
        }

        pages.getpagelist();
      });

      console.log('pages loaded');

      pages.getpagelist();
    },
    getpagelist: function()
    {
      var postdata="search=" + $('#search').val() + "&sortfield=" + sortfield + "&sortdirection=" + sortdirection;

      console.log(config.globals.pagelist_url);
      $.ajax({
        type: 'POST',
        url: config.globals.pagelist_url,
        data: postdata,
        success: function (result){ 
          $('#page_list').html(result);  
        }
      });
    }


  };


  
  $.when(config.load()).done(pages.init);  

});
