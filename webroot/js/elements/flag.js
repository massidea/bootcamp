function flagPage(formData) {
	$.ajax({ 
		type: 'POST',
		data: formData,
		url: jsMeta.baseUrl+"/flags/add/",
		success: function(data) {
			if(data == "1") {
				resetFlash();
				setFlash("Page was flagged successfully");
				showFlash();
				return true;
			} else {
				return false;
			}
		}
	});
}

function initFlagDialog() {
	var message = $("#flagDescription");
	var characters = $("#flagCharacters");

	var limit = 500;
	$(characters).html(limit);
	$(message).live("keydown keyup change",function(){ 
		var chars = countCharactersLeft(this,limit);
		$(characters).html(chars);
	});
	
	$("#flag-page").dialog({
		autoOpen: false,
		resizable: false,
		height: 315,
		width: 430,
		show: {effect: 'slide', duration: 300},
		hide: {effect:'slide', duration: 300, direction: 'right'},
		modal: true,
		buttons: {
			'Flag': function() {
				$("#flagAddForm").submit();
			}, 
			Cancel: function() {
				$(this).dialog("close");
			}
		},
		close: function() {
			
		}
	});
	
	$("#flagAddForm").submit(function(){
		var chars = countCharactersLeft(message,limit);
		if(chars < 0 || chars == limit) {
			eventAnimate(message);
		} else {
			flagPage($(this).serializeArray());
			$("#flag-page").dialog("close");
		}
		return false;
	});
}

$(document).ready(function(){
	initFlagDialog();
	$(".flag-page > a").click(function(){
		$("#flag-page").dialog('open');
		return false;
	});
	
});