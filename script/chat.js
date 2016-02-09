"use-strict";

var chatData;
var peopleArray = [];

var idCurrentOtherPerson;

$(window).load(function(){
	chatData = loadChat();
	//console.log(chatData);
	
	var myid = getCookie(userIdCookie);
	$.each(chatData, function(i,chatObj){
		var otherId;
		if(chatObj.senderId == myid)
			otherId = chatObj.receiverId;
		else
			otherId = chatObj.senderId;
		if(peopleArray.length == 0){
			peopleArray.push(otherId);
		}
		if($.inArray(otherId, peopleArray)==-1){
			peopleArray.push(otherId);
		}
	});
	
	$("#chatOuterPanel").hide();
	populatePeopleList();
	$("#chatOuterPanel").show();
    
    $("#send_message").click(function(){
        var content = escape($("#message_content").val());
        if(content.length > 0 && content.length < 256){
        sendMessage(idCurrentOtherPerson, content)}});
    
});

function sendMessage(idOther, content){
    var sessionCookie = getCookie(cookieName);
	var userId = getCookie(userIdCookie);
	var ret;
	$.ajax({
		async: false,
		type:"POST",
		url: sendMessageUrl,
		data:{
			"userId":userId,
			"session":sessionCookie,
            "userIdTo":idOther,
			"content":content,
		}
	}).always(function(returnData){
		returnStuff = JSON.parse(returnData);
		if('error' in returnStuff){
            ret = !returnStuff.error;
        }
        else {
            ret = false;
        }
	});
	return ret;
}


function populatePeopleList(){
	for(var i = 0; i < peopleArray.length; i++){
		var otherId = peopleArray[i];
		var otherName = getName(otherId);
		var panel = "<a class='list-group-item' id='goToPerson"+otherId+"' onclick='populateChatWindow("+otherId+",&#39;"+JSON.parse(otherName).fName+"&#39;)'>"+JSON.parse(otherName).fName+"</a>"
		var tempId = "#goToPerson"+otherId;
		
		$( "#peopleList" ).append(panel);
		if(i == 0)
			populateChatWindow(otherId, JSON.parse(otherName).fName);
	}
}

function populateChatWindow(personId, personName){
	$("#chatWindowPersonName").text(personName);
	
	$("#chatWindow").empty();
	$.each(chatData, function(i,chatObj){
		if(chatObj.senderId == personId || chatObj.receiverId == personId){
		addChatAtEnd(chatObj);
		}
	});
    
    idCurrentOtherPerson = personId;
}

function loadChat(){
	var sessionCookie = getCookie(cookieName);
	var userId = getCookie(userIdCookie);
	var ret;
	$.ajax({
		async: false,
		type:"POST",
		url: getMessagesUrl,
		data:{
			"userId":userId,
			"session":sessionCookie
		}
	}).always(function(returnData){
		ret = JSON.parse(returnData);
		/*$.each(json, function(i,chatObj){
			addChatAtEnd(chatObj);
		});*/
	});
	return ret;
}

function getName(id){
	var sessionCookie = getCookie(cookieName);
	var userId = getCookie(userIdCookie);
	var ret;
	$.ajax({
		async: false,
		type:"POST",
		url: getNameUrl,
		data:{
			"userId":userId,
			"session":sessionCookie,
			"targetUserId":id
		}
	}).always(function(returnData){
		ret = returnData;
	});
	return ret;
}

var otherUserId;
var otherUserName;

function addChatAtEnd(chatObj){
	var chatId = chatObj.chatId;
	var senderId = chatObj.senderId;
	var receiverId = chatObj.receiverId;
	var timeStamp = chatObj.timeStamp;
	var content = unescape(chatObj.content);
	var isMe = (getCookie(userIdCookie) == senderId);
	
	if(!isMe){
		if(otherUserId != senderId){
			otherUserName = JSON.parse(getName(senderId)).fName;
			otherUserId = senderId;
		}
		if(typeof otherUserName === 'undefined'){
			otherUserName = "User";
		}
	}
	var panel;
	if(isMe)
		panel = "<div class='row'><div class='col-xs-10 col-xs-offset-2'><div class='panel panel-primary'><div class='panel-heading'><h3 class='panel-title'><b>You</b></h3></div><div class='panel-body'>"+content+"</div></div></div></div>"
	else
		panel = "<div class='row'><div class='col-xs-10'><div class='panel panel-default'><div class='panel-heading'><h3 class='panel-title'><b>"+otherUserName+"</b></h3></div><div class='panel-body'>"+content+"</div></div></div></div>"
	$( "#chatWindow" ).append(panel);
}