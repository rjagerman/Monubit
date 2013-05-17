$(function() {
	 $("#dialog-form").dialog({
	     autoOpen: false,
	     height: 300,
	     width: 350,
	     modal: true,
	     buttons: {
	    	 "Voeg de tag toe!": function() {
	    		 var url = rooturl.replace("__tagname__", $("#tagname").val());
	    		 $.get(url, function(json) {
	    			 if(json == "success"){ }
	    			 else{
	    				 alert(json.error.message); 
	    			 }
	    		 });
	    		 $( this ).dialog( "close" );
	    	 }
	     }
	 });

  $("#tagbutton").click(function() {
	  $("#dialog-form").dialog( "open" );
  });
});
