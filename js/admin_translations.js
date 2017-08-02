
$( document ).ready(function() {


  var translations = 
  {
    init: function()
    {
       
      $('#search').on('keyup',_.debounce(function(){
        
        translations.gettranslationslist(config.globals.translationlist_url);

      }, 1000, false));

      $('#translation_type').on('change',function(){
        
        translations.gettranslationslist(config.globals.translationlist_url);

      });

      $('#translations_list').on('click','.paginationlink',function(e){
        e.preventDefault();
        translations.gettranslationslist($(this).attr('href'));
      });

      

      console.log('translations loaded');

      translations.gettranslationslist(config.globals.translationlist_url);
    },
    gettranslationslist: function(url)
    {
      var postdata="search=" + $('#search').val() + "&translation_type=" + $("#translation_type").val();

      $.ajax({
        type: 'POST',
        url: url,
        data: postdata,
        success: function (result){ 
          $('#translations_list').html(result);  
        }
      });
    }


  };


  
  $.when(config.load()).done(translations.init);  

});
