$( document ).ready(function() {
  var obj = 
  {
    init: function()
    {
      console.log(config.globals.url_reorder);
      $('#tags_list').sortable({
        update: obj.updateOrder
      });

       $('#lang_id').on('change', function(event) {
        $(this).closest('form').submit();
      });
    },
    updateOrder: function() {
      $grid = $('#tags_list');

      //console.log('url_reorder='+config.globals.url_reorder);
      var order = $grid.sortable('serialize');
      //order += '&tag_id='+config.globals.tag_id;

      $grid.sortable('toArray', {attribute: "data-item"});

      $.ajax({
          url: config.globals.url_reorder,
          type:"post",
          data:order,
          success:function(data) {
            //console.log(data);
            var href = location.href;
            location.href = href;
          }
      });
    }
  };
  
  $.when(config.load()).done(obj.init);  

});
