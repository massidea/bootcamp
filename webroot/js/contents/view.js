function expandCollapse(name,launcher,target) {
	$(launcher).unbind('click');
	$(target).slideToggle('fast', function() {
		saveToCookie('contentsView', 'expandStatus', name, $(target).is(':hidden') ? 'none' : 'block');
		$(launcher).bind('click', function () { expandCollapse(name,launcher,target); }); 
		setImage(launcher,target);
	});
}

function setImage(launcher,target) {
	var expandButton = $(launcher).children(".icon");
	if ($(target).is(':hidden')){
		$(expandButton).attr("src", "/img/icon_plus_tiny.png");
	} else {
		$(expandButton).attr("src", "/img/icon_minus_tiny.png");
	}
}

function searchPossibleLinks(formData) {
	$.ajax({ 
		type: 'POST',
		dataType: 'json',
		data: formData,
		url: jsMeta.baseUrl+"/linked_contents/contentlinksearch/",
		success: function(data) {
			sendDataToLinkList(data);
			return true;
		}
	});
	return false;
}

function sendDataToLinkList(data) {
	
	var ul = $("#add_new_link > .add_new_link_list > ul");
	var output = '';
	
	$("#ContentsLinkForm > div.input > input, #LinkSearchOptionsViewForm > input:checkbox").live('keyup change', function(){
		output = getLinkedOutput(data);
		$(ul).html(output);
	});
	
	if(data.length === 0) {
		output = '<li>No contents found</li>';
		$(ul).html(output);
	} else {
		output = getLinkedOutput(data);	
		$(ul).html(output);
	}
}

function getLinkedOutput(data) {
	var results = searchFromData($("#ContentsLinkForm > div.input > input").val(),data);
	var thisContentId = $("#ContentsLinkForm > #ContentId").val();
	if(results.length === 0) {
		output = '<li>No contents found</li>';
	} else {
		var output = renderResults(thisContentId,results);
	}
	return output;
}

function searchFromData(searchquery,data) {
	var searchquery = searchquery.toLowerCase();
	var returns = [];
	var options = $("#LinkSearchOptionsViewForm > input:checkbox");
	$.each(data,function(){
		if(this.title.toLowerCase().indexOf(searchquery) > -1 || searchquery.length == 0){
			if(this['class'] == 'challenge' && options[0].checked) {
				returns.push(this);
			} else if(this['class'] == 'idea' && options[1].checked) {
				returns.push(this);
			} else if(this['class'] == 'vision' && options[2].checked) {
				returns.push(this);
			}
		}
	});
	return returns;
}



function linkContents(link,undo) {
	var amountContainer = $("#linked-container > h3 > span");
	var toId = link.id.split('-');
	var linkData = {from:	$("#ContentsLinkForm > #ContentId").val(),
					to:		toId[1]
					};
	$("#add_new_link > .add_new_link_list > ul").html(loading);
	
	$.ajax({ 
		type: 'POST',
		data: linkData,
		url: jsMeta.baseUrl+"/linked_contents/add/",
		success: function(data) {
			if(data == 1) {
				resetFlash();
				setFlash("Contents linked together successfully",'successfull');
				showFlash();
				if(undo) {
					$(link).parent().removeClass('link_deleted');
					$(link).attr('src',jsMeta.baseUrl+'/img/icon_red_cross.png');
					$(amountContainer).text(parseInt($(amountContainer).text())+1);
				} else {	
					$("#ContentsLinkForm").submit();
					addContentToList(link);
				}
				return true;
			} else {
				return false;
			}
		}
	});
}

function addContentToList(link) {
	var container = $("#linked-container > ul");
	var amountContainer = $("#linked-container > h3 > span");
	var amount = $(amountContainer).text();
	
	var username = 'Testiukko'; //When users are ready this information should be logged users' username
	var contentId = link.id.split('-')[1];
	var title = link.text;
	var contentClass = $(link).parent()[0].classList[0].split('-')[1];

	var li = '<li class="border-'+contentClass+' small-margin-top-bottom">\
			<a class="bold left" href="#">'+username+': </a>\
			<img id="delete_linked_content-'+contentId+'" alt="" class="size16 right" src="'+jsMeta.baseUrl+'/img/icon_red_cross.png">\
			<div class="clear"></div>\
			<a class="hoverLink blockLink" href="'+jsMeta.baseUrl+'/contents/view/'+contentId+'">'+title+'</a>\
		</li>';
	$(li).prependTo(container).hide().slideDown().effect('highlight',{},1000);
	$(amountContainer).text(parseInt(amount)+1);

	return;
}



function renderResults(contentId,data) {
	var output = '';
	$.each(data,function(){
		output = output+ '\
		<li class="border-'+this['class']+' shrinkFontMore">\
			<a class="left" href='+jsMeta.baseUrl+'/contents/view/'+this.id+'>\
				<img alt="" src="'+jsMeta.baseUrl+'/img/icon_eye.png">\
			</a>\
			<a id="link_to_content-'+this.id+'" class="left linked-title hoverLink" href="#">'+this.title+'</a>\
			<div class="clear"></div>\
		</li>';
	});
	return output;
}

function deleteContentLink(link) {
	
	var selectedContentId = link.id.split('-')[1];
	var thisContentId = $("#ContentsLinkForm > #ContentId").val();
	
	var formData = {from: thisContentId, to: selectedContentId};
	var amountContainer = $("#linked-container > h3 > span");
	
	$.ajax({ 
		type: 'POST',
		data: formData,
		url: jsMeta.baseUrl+"/linked_contents/delete/",
		success: function(data) {
			if(data == 1) {
				resetFlash();
				setFlash("Content link deleted successfully",'successfull');
				showFlash();
				$(amountContainer).text(parseInt($(amountContainer).text())-1);
				$(link).parent().addClass('link_deleted');
				$(link).attr('src',jsMeta.baseUrl+'/img/icon_undo.png');
				return true;
			} else {
				return false;
			}
		}
	});
}

function contentLinkInit() {
	var linkedsFetched = false;
	
	$("#add_new_link").dialog({
		closeOnEscape: true,
		draggable: true,
		modal: true,
		resizable: false,
		width: 630,
		title: 'Add new link to content',
		dialogClass: "fixedDialog",
		autoOpen: false
	});
	
	$("#linked-addnewlink-link").click(function(){
		$("#add_new_link").dialog("open");
		if(!linkedsFetched) {
			$("#ContentsLinkForm").submit();
			linkedsFetched = true;
		}
		return false;
	});
	
	$("#linked-container > ul > li > img").click(function(){
		if($(this).parent().hasClass('link_deleted')) {
			linkContents(this,true);
		} else {
			deleteContentLink(this);
		}
		
	});
	
	$("#ContentsLinkForm").submit(function(){
		searchPossibleLinks($(this).serializeArray());
		return false;
	});
	
	$(".add_new_link_list > ul > li > .linked-title").live('click',function(){
		linkContents(this);
		return false;
	});
	
}

$(document).ready(function(){
		
	$("#linked-container > h3").click(function(){
		expandCollapse('linked',$(this),$("#linked-container > ul"));
	});

	contentLinkInit();
		
	$("#content-view-readers-list").infiniteCarousel({
		inView: 6,
		advance: 5,
		imagePath: jsMeta.baseUrl+'/js/infinitecarousel/images/',
		textholderHeight: .25,
		padding: '8px'

	});
	
	$("#related-info").tabs({
		fx: { height: 'toggle', duration: 'fast' },
		selected: -1,
		collapsible: true

	});

	
});

