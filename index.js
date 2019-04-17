// document ready
$(function() {
	
	// toggle torrents assoc table
	$("#torrents_assoc_toggle").click(function(){
		$("#torrents_assoc").toggle(400);
	});
	
	// confirmation dialog on delete button
	$("a.confirmation").on("click", function(e) {
	    var link = this;
	    e.preventDefault();
	    $("<div>Êtes-vous sûr ?</div>").dialog({
	        buttons: {
	            "OK": function() {
	                window.location = link.href;
	            },
	            "Annuler": function() {
	                $(this).dialog("close");
	            }
	        }
	    });
	});
	
});
