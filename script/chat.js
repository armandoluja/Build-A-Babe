"use-strict";

var chatData;
var peopleArray = [];
var numberDataPerPersonArray = [];


var idCurrentOtherPerson;
var nameCurrentOtherPerson;

var isView5 = true;

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
        if(content.length > 0 && content.length <= 256){
            $("#message_content").val("");
            sendMessage(idCurrentOtherPerson, content);
        }
        $('#message_content').focus();
    });
    
    $('#message_content').on('keyup keydown focus focusout', function() {
        var content = escape($("#message_content").val());
        if(content.length <= 0 || content.length > 256){
            if(!$("#send_message").hasClass("disabled")){
                $("#send_message").addClass("disabled");
            }
        }else{
            if($("#send_message").hasClass("disabled")){
                $("#send_message").removeClass("disabled");
            }
        }
    });
    
    
    $("#view_5_button").click(function(){
        if(isView5)
            return; //we are already in this view
        $(this).addClass('btn-primary').removeClass('btn-default');
        $("#view_all_button").addClass('btn-default').removeClass('btn-primary');
        isView5 = true;
        $('#message_content').focus();
    });
    
    $("#view_all_button").click(function(){
        if(!isView5)
            return; //we are already in this view
        $(this).addClass('btn-primary').removeClass('btn-default');
        $("#view_5_button").addClass('btn-default').removeClass('btn-primary');
        isView5 = false;
        $('#message_content').focus();
    });
    
    setInterval(function(){
        chatData = loadChat();
        populateChatWindow(idCurrentOtherPerson, nameCurrentOtherPerson);
    }, 300);
    
    $('#message_content').focus();
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
        console.log(returnData);
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
    var count = 0;
	$.each(chatData, function(i,chatObj){
		if((chatObj.senderId == personId || chatObj.receiverId == personId) && (count < 5 || !isView5)){
            addChatAtEnd(chatObj);
            count++;
		}
	});
    
    idCurrentOtherPerson = personId;
    nameCurrentOtherPerson = personName;
    $('#message_content').focus();
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
	$( "#chatWindow" ).prepend(panel);
}