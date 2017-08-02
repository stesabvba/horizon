function scannen(){
	$("#filetable").hide();
	$("#loading").show();
	$("#loading_tekst").show();
	 $.post(site+"json/admin/scan_files.php",function(data){
		 $("#loading_tekst").fadeOut(500,function(){
			 $("#loading_tekst").html("<strong>Bestanden aan het verwerken</strong>");
			 $("#loading_tekst").fadeIn(500,function(){
				 // setTimeout(function(){
					 // location.reload();
				 // }, 5000);
			 });
		 });
	 });
}