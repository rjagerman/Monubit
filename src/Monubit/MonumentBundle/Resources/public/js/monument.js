/*function updateTips(t) {
     $(".validateTips")
         .text(t)
         .addClass("ui-state-highlight");
     setTimeout(function () {
         tips.removeClass("ui-state-highlight", 1500);
     }, 500);
 }

function checkLength(tag) {
     if (tag.val().length > 10 || tag.val().length < 2) {
         tag.addClass("ui-state-error");
         updateTips("Lengte van tag tussen " + min + " and " + max + ".");
         return false;
     } else {
         return true;
     }
 }
*/

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
