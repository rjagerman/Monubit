/**
 * Adds a tag
 * @param me The dialog that called the function
 */
function addTag(me) {
   	var url = $('#addtag').attr('href').replace("__tag__", $("#tagname").val());
   	$.get(url, function(json) {
	   	if(json[0] == "success"){
	   		$('.tags').replaceWith(json.html);
	   	} else{
	   		alert(json.error.message);
	   		$("#tag-dialog").dialog( "open" );
	   	}
   	});
   	$("#tagname").val("");
   	$(me).dialog( "close" );
}

$(function() {
	
	// Constructs the dialog
	$("#tag-dialog").dialog({
	    autoOpen: false,
	    height: 300,
	    width: 350,
	    modal: true,
	    buttons: {
		   	"Voeg de tag toe!": function() { addTag(this); }
	    },
	});	
	
	// Submitting the form
	$("#tag-dialog form").submit(function(e) {
		addTag($("#tag-dialog"));
		return false;
	});
	
	// Open the dialog when clicking the button
	$("#addtag").click(function() {
		$("#tag-dialog").dialog( "open" );
		return false;
	});
	
	
});
