function sendPrivateMessage(formData) {
	$.ajax({ 
		type: 'POST',
		data: formData,
		url: jsMeta.baseUrl+"/private_messages/send/",
		success: function(data) {
			if(data) {
				setFlash("Message sent successfully",'successfull');
				showFlash();
			} else {
				setFlash("Failure in message send. Message not delivered");
				showFlash();
			}
		}
	});
}

function initSendPrivateMessageDialog() {
	var message = $("#PrivateMessageMessage");
	var characters = $("#privateMessageCharacters");
	var receiver = $("#PrivateMessageReceiver");
	var limit = 1000;
	$(characters).html(limit);
	$(message).live("keydown keyup change",function(){ 
		var chars = countCharactersLeft(this,limit);
		$(characters).html(chars);
	});
	
	$("#send_private_message").dialog({
		autoOpen: false,
		resizable: false,
		height: 310,
		width: 450,
		show: {effect: 'slide', duration: 300},
		hide: {effect:'slide', duration: 300, direction: 'right'},
		modal: true,
		buttons: {
			'Send Message': function() {
				$("#PrivateMessageForm").submit();
			}, 
			Cancel: function() {
				$(this).dialog("close");
			}
		},
		close: function() {
			$(message).val("");
			$(characters).text(limit);
			$("#PrivateMessageTo").text("");
			$(receiver).val("");
		}
	});
	
	
	$("#PrivateMessageForm").submit(function(){
		var chars = countCharactersLeft(message,limit);
		if(chars < 0 || chars == limit) {
			eventAnimate(message);
		} else {
			sendPrivateMessage($(this).serializeArray());
			$("#send_private_message").dialog("close");
		}
		return false;
	});

}

$(document).ready(function(){
	initSendPrivateMessageDialog();
	
	$(".send-message > a").click(function() {
		var id = $(this).siblings('.send-message-id');
		var name = $(this).siblings('.send-message-name');
		$("#PrivateMessageTo").text(name.val());
		$("#PrivateMessageReceiver").val(id.val());
		$("#send_private_message").dialog("open");
		return false;
	});
	
});