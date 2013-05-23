function addTag(me) {
   	console.log("Voeg tag toe");
   	var url = $('#addtag').attr('href').replace("__tag__", $("#tagname").val());
   	console.log(url);
   	$.get(url, function(json) {
	   	if(json[0] == "success"){
	   		$('.tags').replaceWith(json.html);
	   	} else{
	   		alert(json.error.message);
	   		$("#tag-dialog").dialog( "open" );
	   	}
   	});
   	$(me).dialog( "close" );
}

$(function() {
	$("#addtag").click(function() {
		$("#tag-dialog").dialog( "open" );
		return false;
	});
	
	$("#tag-dialog").dialog({
	    autoOpen: false,
	    height: 300,
	    width: 350,
	    modal: true,
	    buttons: {
		   	"Voeg de tag toe!": function() { addTag(this); }
	    },
	    open: function() {
	    	$("#tag-dialog").keypress(function(e) {
			    if (e.keyCode == $.ui.keyCode.ENTER) {
			    	addTag(this);
			    	return false;
			    }
			});
	    }
	});	
});
