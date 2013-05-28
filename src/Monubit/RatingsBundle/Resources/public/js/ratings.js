$(document).ready(function() {
	$('.auto-submit-star').rating({ 
		callback: function(value, link) {
			if (typeof $(this).attr('id') != 'undefined') {
				// Add rating
				var url = $("#ratings").find("form").attr("action");
				url = url.substring(0, url.lastIndexOf("/") + 1) + $("input#" + $(this).attr("id")).val();
				$.get(url, function(data) {  });
			} else {
				// Remove current rating
				$.get($("form#removerating").attr("action"));
			}
		}
	});
	var ratingHtml = '';
	$('#ratings.disabled').mouseenter(function() {
		$(".rating").hide();
		$(".disabledmessage").show();
	}).mouseleave(function() {
		$(".rating").show();
		$(".disabledmessage").hide();
	});
});
