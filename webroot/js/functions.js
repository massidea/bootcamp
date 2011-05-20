/**
 *  Global Javascript-functionality for the website
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
 *  @author many people :O
 */

/**
*	The captcha changer, now with baseurl
*	!!! Should be moved out of global functions !!!
*   @param baseUrl
*/
function reloadCaptcha(baseUrl){
	var image = document.getElementById('registration_captcha');
    // time used to make sure the image URL is always different
	image.src = baseUrl+"/en/account/captcha" + '?' + (new Date()).getTime();
}

/**
*   Activate the given element, deactivate all others.
*   The tabs (clickable elements) must be named t0,t1,t2...tn
*
*   @param e        : which element should be the active one
*   @param max:     : how many clickable elements are there anyway?
*   @param common   : the common pre-numeric identifier of the tabs.
*/
function replaceActive(element, max, common) {
    //first, let's activate the requested element
    document.getElementById(element).className = "active";

    //then, deactivate the rest
    for (i=0;i<=max;i++) {
        if (common + i != element) {    // ignore the element you just changed
            document.getElementById(common+i).className = "";
        }
    }
}

/**
 * Loops forever to see onlineIdle time.
 * @return onlineIdle()
 */
function onlineIdle() {
	var json = jQuery.parseJSON($('#jsmetabox').text());
	var url = json.idleRefreshUrl;
	$.ajax({
		type: "POST",
		url: url,
		success: function(msg) {
			setTimeout("onlineIdle()", idleInterval);
		}
	});
}

/** multiFile
 * 
 * function to create new file input for each file chosen, hides the old one. Also makes a button to make 
 * it possible to remove a chosen file
 *
 * @param   obj      file input object
 * @param  message    translated text for remove file button
 */
function multiFile(obj) {
	var json = jQuery.parseJSON($('#jsmetabox').text());
	var baseUrl = json.baseUrl;

	var allowedFiles = {
		'.doc' 		: 1,
		'.docx' 	: 1,
		'.png' 		: 1,
		'.gif' 		: 1,
		'.jpg' 		: 1,
		'.jpeg' 	: 1,
		'.zip' 		: 1,
		'.xls' 		: 1,
		'.mpp' 		: 1,
		'.pdf' 		: 1,
		'.wmv' 		: 1,
		'.avi' 		: 1,
		'.mkv' 		: 1,
		'.mov' 		: 1,
		'.mpeg' 	: 1,
		'.mp4' 		: 1,
		'.divx' 	: 1,
		'.flv' 		: 1,
		'.ogg'	 	: 1,
		'.3gp' 		: 1,
		'.txt'		: 1
	}
	
	var file = $(obj).val();

	var re = /\..+$/;
    var ext = file.match(re);

	if ( $(":file[value="+file+"]").length == 1 && allowedFiles[ext]) {
		if ($(obj).is(':visible')) {
			$(obj).hide();
			$(obj).before("<input id='content_file_upload' type='file' onchange='multiFile(this);' name='content_file_upload[]' />");
			$(obj).parent().after("<div class='file_row field'><div class='clear' /><img id='removeFile' class='right' src='" + baseUrl + "/images/icon_red_cross.png' style='cursor: pointer'/><div class='content_file_list_file'>"+ file + "</div></div>");
			$("#removeFile").click(function() {
				$(this).parent().remove();
				$(obj).remove();
			});
		}
	}
	else {
		$(obj).val("");
		alert("Error: \nDuplicate file or invalid filetype");
	}
}

/**
 * !!!!!!!!!!!!
 * !!! NOTE !!!
 * !!!!!!!!!!!!
 * Functions below should be changed to jQuery. Would save alot of lines and make it more readable.
 * selectAllPrivmsgs
 * selectOnlyThisMsg
 * acceptAllUsrInWaitinglist
 * denyAllUsrInWaitinglist
 * unselectRadiobutton
 * 
 * something like this should replace things:
 * 
   if ($(this).is(':checked')) $(".class").attr("checked","checked"); 
   else $(".class").removeAttr("checked"); 

 */

/**
* selectAllPrivmsgs
* 
* function to select or unselect all private messages for deletion
*  !!! READ ABOVE !!!
*/
function selectAllPrivmsgs()
{
	// Get the form elements
	var elems = document.getElementById('delete_privmsgs');
	var checked = document.delete_privmsgs.select_all.checked;

	// Change values according to the "select_all" checkbox
	for (var i = 1; i < elems.elements.length; i++) {
		elems.elements[i].checked = checked;
	}
}

/**
* selectOnlyThisMsg
* 
* function to select only one message (used when a message's "Delete"-link is pressed)
* !!! READ ABOVE selectAllPrivmsgs !!!
*/
function selectOnlyThisMsg(id)
{
	// Get the form elements
	var elems = document.getElementById('delete_privmsgs');
	
	// Set everything unchecked
	document.delete_privmsgs.select_all.checked = false;
	for (var i = 1; i < elems.elements.length; i++) {
		elems.elements[i].checked = false;
	}
	
	// Mark as checked only the message that is going to be deleted
	document.getElementById('select_' + id).checked = true;
}

/**
* acceptAllUsrInWaitinglist
*
* function to select or unselect all accept users from waiting list
* !!! READ ABOVE selectAllPrivmsgs !!!
*/
function acceptAllUsrInWaitinglist()
{
	// Get the form elements
	var elems = document.getElementById('group_waiting_list_form');
	var checked = document.group_waiting_list_form.accept_all.checked;

	// Change values according to the "accept_all" checkbox
	for (var i = 1; i < elems.elements.length; i++) {
        if (elems.elements[i].id[0] == "a")
            elems.elements[i].checked = checked;
	}

	for (i = 1; i < elems.elements.length; i++) {
        if (elems.elements[i].id[0] == "d")
            elems.elements[i].checked = false;
	}
}

/**
* denyAllUsrInWaitinglist
*
* function to select or unselect all deny users from waiting list
* !!! READ ABOVE selectAllPrivmsgs !!!
*/
function denyAllUsrInWaitinglist()
{
	// Get the form elements
	var elems = document.getElementById('group_waiting_list_form');
	var checked = document.group_waiting_list_form.deny_all.checked;

	// Change values according to the "deny_all" checkbox
	for (var i = 1; i < elems.elements.length; i++) {
        if (elems.elements[i].id[0] == "d")
            elems.elements[i].checked = checked;
	}

    for (i = 1; i < elems.elements.length; i++) {
        if (elems.elements[i].id[0] == "a")
            elems.elements[i].checked = false;
	}
}

/**
* unselectRadiobutton
*
* Function to unselect accept all and deny all radio buttons
* !!! READ ABOVE selectAllPrivmsgs !!!
*/
function unselectRadiobutton()
{
	document.group_waiting_list_form.accept_all.checked = false;
    document.group_waiting_list_form.deny_all.checked = false;
}

/**
 * makeLink
 * 
 * Makes a link out of whole element if it has 'a' as child, 
 * taking its href 
 * 
 * @param obj
 */
function makeLink(obj) {
	var url = $(obj).find("a").attr('href');
	$(location).attr('href', url);
}