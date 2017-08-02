var medialibrary;
$( document ).ready(function() {


  medialibrary = 
  {
    init: function()
    {
      
      var obj = $("#dropzone");
      obj.on('dragenter', function (e) 
      {
          e.stopPropagation();
          e.preventDefault();
          $(this).css('border', '2px solid #0B85A1');
      });
      obj.on('dragover', function (e) 
      {
           e.stopPropagation();
           e.preventDefault();
      });
      obj.on('drop', function (e) 
      {
       
           $(this).css('border', '2px dotted #0B85A1');
           e.preventDefault();
           var files = e.originalEvent.dataTransfer.files;
            $('#uploading_files').show();
        
           medialibrary.handleFileUpload(files,obj);
      });

      $(document).on('dragenter','.media', function (e) 
      {
          e.stopPropagation();
          e.preventDefault();
          $(this).css('border', '2px solid #0B85A1');
      });

      $(document).on('dragleave','.media', function (e) 
      {
          e.stopPropagation();
          e.preventDefault();
          $(this).css('border', 'none');
      });


      $(document).on('dragover','.media', function (e) 
      {
           e.stopPropagation();
           e.preventDefault();
      });
      
      $(document).on('drop','.media', function (e) 
      {
          var media_id = ($(this).attr('id'));
          var result = confirm("Wil je de bestaande media overschrijven?");
          if (result == true) {
              $(this).css('border', '2px dotted #0B85A1');
              e.preventDefault();
              var files = e.originalEvent.dataTransfer.files;
              $('#uploading_files').show();
        
              medialibrary.handleFileOverWrite(files,$(this),media_id);
          }        
          
      });

      $(document).on('dragenter', function (e) 
      {
          e.stopPropagation();
          e.preventDefault();
      });
      $(document).on('dragover', function (e) 
      {
        e.stopPropagation();
        e.preventDefault();
        obj.css('border', '2px dotted #0B85A1');
      });
      $(document).on('drop', function (e) 
      {
          e.stopPropagation();
          e.preventDefault();
      });

      $('#medialist').on('click','.paginationlink',function(e){
        e.preventDefault();
        config.globals.medialist_url=($(this).attr('href'));
        medialibrary.getmedialist();
      });



      $('#search').on('keyup',_.debounce(function(){
        
        medialibrary.getmedialist();

      }, 1000, false));

      $('#search_tags').on('change',function(){
        
        medialibrary.getmedialist();

      });

      

      console.log('media library loaded');

      medialibrary.getmedialist();
    },
    getmedialist: function()
    {
      var postdata="search="+$('#search').val()+"&search_tags=" + $("#search_tags").val();

      console.log(config.globals.medialist_url);
      $.ajax({
        type: 'POST',
        url: config.globals.medialist_url,
        data: postdata,
        success: function (result){ 
          $('#medialist').html(result);  
        }
      });
    },
    UploadMedia: function(formData,status)
    {
        var uploadURL =config.globals.upload_url;
        
        var jqXHR=$.ajax({
                xhr: function() {
                var xhrobj = $.ajaxSettings.xhr();
                if (xhrobj.upload) {
                        xhrobj.upload.addEventListener('progress', function(event) {
                            var percent = 0;
                            var position = event.loaded || event.position;
                            var total = event.total;
                            if (event.lengthComputable) {
                                percent = Math.ceil(position / total * 100);
                            }
                            $('#files').html('<p>' + percent + '% voltooid</p>');
                           
                        }, false);
                    }
                return xhrobj;
            },
        url: uploadURL,
        type: "POST",
        contentType:false,
        processData: false,
            cache: false,
            data: formData,
            success: function(data){
              
              $('#files').html('<p>File uploaded</p>');
              $('#uploading_files').hide();
              medialibrary.getmedialist();
            }
        }); 
     
        
    },
    OverwriteMedia: function(formData,status)
    {
        var uploadURL =config.globals.overwrite_url;
        
        var jqXHR=$.ajax({
                xhr: function() {
                var xhrobj = $.ajaxSettings.xhr();
                if (xhrobj.upload) {
                        xhrobj.upload.addEventListener('progress', function(event) {
                            var percent = 0;
                            var position = event.loaded || event.position;
                            var total = event.total;
                            if (event.lengthComputable) {
                                percent = Math.ceil(position / total * 100);
                            }
                            $('#files').html('<p>' + percent + '% voltooid</p>');
                           
                        }, false);
                    }
                return xhrobj;
            },
        url: uploadURL,
        type: "POST",
        contentType:false,
        processData: false,
            cache: false,
            data: formData,
            success: function(data){
              
              $('#files').html('<p>File uploaded</p>');
              $('#uploading_files').hide();
              medialibrary.getmedialist();
            }
        }); 
     
        
    },
    handleFileUpload: function(files,obj)
    {
       for (var i = 0; i < files.length; i++) 
       {
            var fd = new FormData();
            fd.append('file', files[i]);
            fd.append('tags',$('#tags').val());
            medialibrary.UploadMedia(fd);
     
       }

       medialibrary.getmedialist();
    },
    handleFileOverWrite: function(files,obj,media_id)
    {

      if(files.length>0)
      {
        var fd = new FormData();
        fd.append('file',files[0]);
        fd.append('media_id',media_id);
        medialibrary.OverwriteMedia(fd);
        medialibrary.getmedialist();
      }
  
    }


  };


  
  $.when(config.load()).done(medialibrary.init);  

});
