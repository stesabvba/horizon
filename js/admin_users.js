var users;
var url;
$( document ).ready(function() {


  users = 
  {
    init: function()
    {

      console.log(config.globals.userlist_url);

      url = config.globals.userlist_url;
      
      $('#search').on('keyup',_.debounce(function(){
        url = config.globals.userlist_url;
        users.getuserlist();

      }, 1000, false));

      $('#user_linktype').on('change',function(){
        users.getuserlist();
      });

      $('#user_list').on('click','.paginationlink',function(e){
        e.preventDefault();
        url = $(this).attr('href');
        users.getuserlist($(this).attr('href'));
      });
      

      console.log('users loaded');

      users.getuserlist();
    },
    getuserlist: function()
    {
      var postdata="search=" + $('#search').val() + "&user_linktype=" + $("#user_linktype").val()

      $.ajax({
        type: 'POST',
        url: url,
        data: postdata,
        success: function (result){ 
          $('#user_list').html(result);  
        }
      });
    }


  };


  
  $.when(config.load()).done(users.init);  

});
