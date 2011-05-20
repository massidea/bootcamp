/**
 *  Global javascript variables, functions and events for website.
 *
 *  This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License 
 *  as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied  
 *  warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for  
 *  more details.
 *
 *  You should have received a copy of the GNU General Public License along with this program; if not, write to the Free 
 *  Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 *  License text found in /license/ and on the website.
 *
 *  Licence:  GPL v2.0
 * 
 * @author Jari Korpela
 * 
 */

/**
 * Initialize jsMeta so it can be used globally around page
 */
var jsMeta = "";
var loading = "";

/**
 * 
 * @param 	text	Text to be set in flash message
 * @param	style	Sets flash with different style
 * @return 	boolean True If success, else false
 */
function setFlash(text, style) {
	if($("#flash").is(':empty')) {
		if(style == 'successfull') {
			$("#flash").html('<div id="successfull_operation" class="flashBox">'+text+'</div>');
		} else {
			$("#flash").text(text);
		}
		return true;
	}
	return false;
}

/**
 * If flash message is set up a, it is displayed and then removed and emptied
 */
function showFlash() {
	if(!$("#flash").is(':empty')) {
		$("#flash:hidden").slideDown(500).delay(5000).slideUp(1000,function(){ $("#flash").empty(); });
	}
}

/**
 * resetFlash stops effects, jumps to the end of effect, clears command queue, hides and empties the flash message. 
 * 
 */
function resetFlash() {
	$("#flash").stop(true,true).hide().empty();
}


/**
 * saveToCookie
 * Adds cookie via ajax request
 * @param 	page		Page to add cookie
 * @param 	event		Cookies' event name
 * @param 	type		Cookies' type
 * @param 	value		Cookies' value
 * @param 	successMsg	Not required. Shows flash message with text successMsg if defined
 */
function saveToCookie(page, event, type, value, successMsg) {
	data = {'page':page,'event':event,'type':type,'value':value};
	$.ajax({ 
		type: 'POST',
		data: data,
		url: jsMeta.baseUrl+"/cookies/add/",
		success: function(data) {
			if(successMsg && setFlash(successMsg)) {
				showFlash();
			}
		}
	});
}

/**
 * countCharactersLeft
 * Use this function to count characters left that can be written in text fields
 * @param 	jQuery object o		Object to check
 * @param 	int limit			Limit to check on
 * @return	int charactersLeft	Returns number of character space left
 */
function countCharactersLeft(o,limit) {
	var newLines = $(o).val().split("\n").length - 1;
	var length = $(o).val().length + newLines;
	return limit-length;
}

/**
 * eventAnimate
 * Function is used to show user that he activated some event. Background returns back to original.
 * @param jQuery object o	Object to put the animation to	
 * @param string color		The color to use
 * @return null
 */
function eventAnimate(o,color) {
	o.stop(true,true);
	backColor = o.css('backgroundColor');
	if(!color) { 
		color = 'red';
	}
	o.animate({backgroundColor: color}, 1).animate({backgroundColor: backColor}, 1400);
}

function hexFromRGB(r, g, b) {
	var hex = [
		r.toString( 16 ),
		g.toString( 16 ),
		b.toString( 16 )
	];
	$.each(hex, function(nr,val) {
		if (val.length === 1) {
			hex[ nr ] = "0" + val;
		}
	});
	return hex.join("").toUpperCase();
}

$(document).ready(function(){
	
	/**	
	 * jsMeta box contains information about:
	 * - userId
	 * - idleRefreshUrl
	 * - baseUrl
	 * - currentPage
	 */
	
	jsMeta = jQuery.parseJSON($("#jsmetabox").text());
	loading = '<img alt="Loading..." src="'+jsMeta.baseUrl+'/img/ajax-loader-black.gif">';
	
	/**
	 * Needs commenting
	 */
	//idleInterval = 181000;
	//setTimeout("onlineIdle()", idleInterval);
	
	/**
	 * Dialog is jQuery UI widget (http://jqueryui.com/demos/dialog/)
	 * - login_box: 			Opens the log in dialog
	 * - login_box_opendid: 	Opens the open id log in box
	 * - addNewContentDialog:	Opens the add new content dialog
	 * - terms:					Opens Register Description
	 * - privacy:				Opens Network Services Agreement
	 */
	$("#login_box").dialog({
		closeOnEscape: true,
		draggable: false,
		modal: true,
		resizable: false,
		title: 'Login to Massidea',
		dialogClass: "fixedDialog",
		autoOpen: false
	});

	$("#login_box_openid").dialog({
		closeOnEscape: true,
		draggable: false,
		modal: true,
		resizable: false,
		title: 'Login with OpenID',
		dialogClass: "fixedDialog",
		autoOpen: false
	});
	
	$("#addNewContentDialog").dialog({
		closeOnEscape: true,
		draggable: false,
		modal: true,
		resizable: true,
		title: 'Select content type',
		dialogClass: "fixedDialog",
		autoOpen: false,
		width: 625,
		height: 345
	});
	
	$("#terms").dialog({
		closeOnEscape: true,
		draggable: false,
		modal: true,
		resizable: true,
		title: 'Register Description',
		autoOpen: false,
		dialogClass: "fixedDialog",
		width: 700,
		height: 100
	});
	
	$("#privacy").dialog({
		closeOnEscape: true,
		draggable: false,
		modal: true,
		resizable: true,
		title: 'Network Services Agreement',
		autoOpen: false,
		position: 'top',
		dialogClass: "fixedDialog",
		width: 700,
		height: 400
	});
	
	$("#loginlink").click(function() {
			eventAnimate($(this));
	});
	
	/**
	 * Clicking add new content button:
	 * If user is logged in, open the add_new_content dialog.
	 * Else show login_box dialog and focus on username field.
	 */
	$("#addNewContentButton").click(function(){
		$("#addNewContentDialog").dialog("open");
	});
	
	/**
	 * Clicking privacy link opens the privacy dialog
	 */
	$("#privacy_link").click(function(e){
		$("#privacy").dialog("open");
		return false;
	});
	
	/**
	 * Clicking any login link in anywhere site:
	 * Opens the login_box dialog and focuses to the username field.
	 */
	$("a.loginLink").each(function() {
		$(this).click(function (event) {
			event.preventDefault();
			$("#login_box").dialog( "option", "title", 'Login to Massidea' );
			$("#login_box").dialog("open");
			$("#login_box > form > div:nth-child(2) > input").focus();
		});
	});

	/**
	 * Clicking open id login link:
	 * Close the login_box dialog and opens the login_box_openid dialog and focus on the openid field. 
	 */
	$("#login_link_openid").click(function () {
		$("#login_box").dialog("close");
		$("#login_box_openid").dialog("open");
		$("#login_box_openid > form > div:nth-child(2) > input").focus();
	});
	
	/**
	 * Clicking Back to Massidea Login link in open id login:
	 * Closes the login_box_openid dialog and opens the login_box dialog.
	 */
	$("#login_link_in_box").click(function () {
		$("#login_box_openid").dialog("close");
		$("#login_box").dialog("open");
		$("#login_box > form > div:nth-child(2) > input").focus();
	});
	
	/**
	 * Moving mouse over the logged in username in header:
	 * In: 	Opens user options menu and clears the event queue (used for deactivating the out event)
	 * Out: Closes user options menu after 1000ms
	 */
	$("#loginlink").hover(
			 function(){
				 var optPos = $("#loginlink").position().left;
				 $("#user_options").stop(true,true).css("left",optPos).show();
				 },
			 function(){$("#user_options").delay(1000).slideUp();}
	);
	
	/**
	 * Moving mouse over the user options menu in header:
	 * In: 	Clears the event queue. Used for deactivating the out event
	 * Out: Closes user options menu after 1000ms
	 */
	$("#user_options").hover(
			function(){$("#user_options").stop(true,true)},
			function(){$("#user_options").delay(1000).slideUp();}
	);
	
	/**
	 * When selecting option from Footers select box direct to values url
	 */
	$('#project_groups').change(function() {
		var value = $(this).val();
		if(value != '' && value != undefined && value != 0) {
			window.open(value);
		}
	});
	
	showFlash();

/**		 
	 $("#notification_close").live("mouseover mouseout click", function(event){ 
		 if(event.type == "mouseover")
			 $("a",this).addClass("notification_close_button");
		 if(event.type == "mouseout") $("a",this).removeClass("notification_close_button");
		 if(event.type == "click") $("#notification_box").slideToggle();
	 });


	 $.ajax({ // Should be moved to functions-->
		url: jsMeta.baseUrl+"/en/ajax/getnotifications/",
		success: function(data) {
			if(data) {
				$("#notification_box").html(data);
				$("#notification_link").click( function() {$("#notification_box").slideToggle();} );
				$("#notification_link").css("cursor","pointer");
				var notificationIds = jQuery.parseJSON($("#notification_box > #notification_ids").text());
				 $.each(notificationIds,function(index,value) {
					 var div = "#notification_list_id_"+value;
					 $(div+"> .notification_list_row_first > .notification_time > a").live("click",function(){
						 if($(".notification_list_row_other",div).is(":hidden")) {
							 $(div+"> .notification_list_row_first > .notification_time > a").text("Less");
						 }
						 else { $(div+"> .notification_list_row_first > .notification_time > a").text("More"); }
						 $(".notification_list_row_other",div).slideToggle();

					 });
				 });
				$("#notification_box").tabs();
				$("#notification_link").attr("src",jsMeta.baseUrl+"/images/notifications_a.png");
				$("#notification_totals").html("("+$("#notification_total").text()+")");
				
			}
		}	
	 });
	
	$('.youtube-reference').click(function() { //Since this is not a global event it should be moved to its own specific js file.
		$(this).removeClass('hover-link');
		$(this).find('.youtube-preview').toggle();
		$(this).find('.youtube-embed').toggle();
		$(this).unbind('click');
	});
*/
});



