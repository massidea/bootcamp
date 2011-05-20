/**
 *	ContentForm.js - Javascript functionality to add/edit content actions
 *
 *	This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License 
 * 	as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
 * 	
 * 	This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied  
 * 	warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for  
 * 	more details.
 * 	
 * 	You should have received a copy of the GNU General Public License along with this program; if not, write to the Free 
 * 	Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *	
 *	 License text found in /license/ and on the website.
 *	
 *	authors:	Jaakko Paukamainen <jaakko.paukamainen@student.samk.fi>,
 *				Jari Korpela
 *	Licence:	GPL v2.0
 */	

function textValidation(obj) {
	var thisProgress = $('#progressbar_'+obj.name);
	var regex = inputValidations[obj.name];
	if (regex.test($(obj).val())) { }
	else {
		progressText = "Tag not valid!";
		$(thisProgress).addClass('bad');
		$(thisProgress).html(progressText);
	}
}

function textCount(obj,inputDefinitions,allInputs) {
	var field = $(obj).parent().parent();

	var thisMin = inputDefinitions[field[0].id][0];
	var thisMax = inputDefinitions[field[0].id][1];
	var thisReq = inputDefinitions[field[0].id][2];
	// Quick hack to prevent newline to fail whole validator
	var newLines = $(obj).val().split("\n").length - 1;
	var curLength = $(obj).val().length + newLines;
	var curLeft = (thisMax-curLength);
	
	var thisProgress = $('#'+ field[0].id + '> .limit');

	if(curLength < thisMax) {
		progressText = curLeft + " until limit";
		$(thisProgress).attr('class','limit ok');
	}
	if(curLength > thisMax) {
		progressText = Math.abs(curLeft) + " too many";
		$(thisProgress).attr('class','limit bad');
	}
	if(curLength == thisMax) {
		progressText = "at the limit";
		$(thisProgress).attr('class','limit ok');
	}
	
	if(curLength == 0 && thisReq) {
		progressText = "required";
		$(thisProgress).attr('class','limit bad');
	}

	$(thisProgress).html(progressText);
	publishValidation(allInputs);	
}

function enableSubmit(bool) {
	if(bool) {
		$("#content_send > input").removeAttr('disabled');
		$("#content_send > input").removeClass('bad');
		$("#content_send > input").addClass('ok');
	} else {
		$("#content_send > input").attr('disabled', 'disabled');
		$("#content_send > input").removeClass('ok');
		$("#content_send > input").addClass('bad');
	}
}

function publishValidation(allInputs) {
	if($("#content_publish > fieldset > input:first").is(":checked")) {
		var submitOk = true;
		$(allInputs).each(function(){
			var thisProgress = $('#'+ $(this).parent().parent()[0].id + '> .limit');
			if(thisProgress.hasClass('bad')) { submitOk = false; }
		});
		
		if(submitOk) {
			enableSubmit(true);
			return;
		} else {
			enableSubmit(false);
			return;
		}
	}
	enableSubmit(true);
	return;
}

$(document).ready(function() {

	// Get all input elements
	var allInputs = $("#contents :input[type=text], #contents :input[type=textarea]");
	var publish = $("#content_publish > fieldset :input");
	
	// Definitions for input boxes ([0] = minimum, [1] = maximum, [2] = required (1 true/0 false)
	var inputDefinitions = {
		'content_title': 				[1,  140, 1],
		'content_lead': 				[1,  320, 1],
		'content_research': 			[1,  140, 1],
		'content_solution': 			[1,  140, 1],
		'content_opportunity': 			[1,  140, 1],
		'content_threat': 				[1,  140, 1],
		'content_tags': 				[1,  120, 1],
		'content_companies':			[0,  120, 0],	
		'content_body': 				[0, 4000, 0],
		'content_references': 			[0, 2000, 0]
	};
	
	//var inputValidations = { 
	//	'content_keywords':				XRegExp("^[\\p{L}0-9, ]*$")		
	//};
	/*
	var inputHelps = {
		'content_header': "<strong>Headline</strong><br /> Grabâ€™s attention, summarize the whole thought and attracts to read the rest of the story.",
		'content_keywords': "<strong>Keywords</strong><br /> Words that capture the essence of the topic of your content. <br /> Are important, since we use them for related content automatization. <br />Use commas '<strong>,</strong>' to separate tags!",
		'content_textlead': "<strong>Lead chapter</strong><br /> Together with headline answers to what, why and whom questions and sum up the whole thought. <br /> This text is shown in search result lists",
		'content_text': "<strong>Body text</strong><br /> Is elaborating the headline and lead paragraph. Answer following questions:  <br /> 1) What is the insight, <br /> 2) Why the insight is important and valuable, <br /> 3) Who is the target group and whom should be interested, <br /> 4) When (temporal dimension) the insight is topical and <br /> 5) Where (geographical, physical location or circumstances) the insight is topical?",
		'content_related_companies': "<strong>Related companies and organizations</strong><br /> Similar as keywords but present existing companies and organizations, which are related to your insight. <br />Use commas '<strong>,</strong>' to separate",		
		'content_research': "<strong>Research question</strong><br /> The single question in which you need an answer.",
		'content_opportunity': "<strong>Opportunity</strong><br /> Identify the most important opportunity if vision is realized.",
		'content_threat': "<strong>Threat</strong><br /> Identify the most important threat if vision is realized.",
		'content_solution': "<strong>Solution</strong><br /> Summarize your idea's key point to a one sentence.",
		'content_references': "<strong>References</strong><br /> Include references in your content when possible (e.g. website, book or article)."
	};*/
	
	$(publish).live('change', function(){
		if(this.value == 0) {
			enableSubmit(true);
		} else {
			publishValidation(allInputs);
		}
	});
	                 
	$(allInputs).live('keydown keyup', function(){
		textCount(this,inputDefinitions,allInputs);
		//if (this.name == "content_keywords") textValidation(this);
	});
	
	
	$(allInputs).each(function(){
			textCount(this,inputDefinitions,allInputs);
			/*
			if (this.name == "content_keywords") textValidation(this);
			
			$(this).focus(function (event) {
				$(this).parent().parent().css("z-index",9999);
				$(this).css("position","relative");
				var areaWidth = 729;
				var progressWidth = 109;
				var boxWidth = 385;
				$(this).css("width",areaWidth+"px");
				$("#progressbar_"+this.name).css("position","relative");
				$("#progressbar_"+this.name).css("left",areaWidth-boxWidth-progressWidth+"px");
				$("#progressbar_"+this.name).css("top","-23px");
			});
			$(this).blur(function (event) {
				$(this).css("position","");
				$(this).css("width","");
				$("#progressbar_"+this.name).css("position","");
			}); */
			/*$(this).qtip({
				content: inputHelps[this.name],
				style: { 
					width: "300",
					background: "#DDDDDD",
					border: {
				      width: 2,
				      radius: 2,
				      color: '#7F9DB9'
				   }
				},
				show: { when: { event: "focus" } },
				hide: { when: { event: "blur" } },
				position: { corner: { target: 'topLeft', tooltip: 'bottomLeft' } }
			});*/
	});
		
	/**
	 * Set content publish button to disabled after click
	 * and submit form.
	 */ /*
	$('.content_manage_button').click(function() {	
		if($(this).attr('id') == "content_publish_button") {
			canExit = 1;
			window.onbeforeunload = null;
			$("#content_publish").val('1');
			$('.content_manage_button').attr('disabled', 'disabled');
			$('#form_content_realcontent').has(this).children('form').submit();
		} else if($(this).attr('id') == "content_save_button") {
			canExit = 1;
			window.onbeforeunload = null;
			$("#content_publish").val('');
			$("#content_save").val('1');
			$('.content_manage_button').attr('disabled', 'disabled');
			$('#form_content_realcontent').has(this).children('form').submit();
		} else if($(this).attr('id') == "content_preview_button") {
			canExit = 0;
			window.onbeforeunload = unloadWarning;
			generatePreview();
		}
	}); */
});

