"use-strict";
var chat_panel;
var attributes_panel;
var preferences_panel;
var gallery_panel;
var profile_pic_panel;
var recently_viewed_panel;
var view_saved_users_panel;
var browse_users_panel;
var chooseFileInput;
//trigger this to open file explorer
var uploadImageForm;
//submit this to upload the file
var userInfo;

$(window).load(function() {
	chat_panel = $("#chat_panel");
	attributes_panel = $("#attributes_panel");
	preferences_panel = $("#preferences_panel");
	gallery_panel = $("#gallery_panel");
	profile_pic_panel = $("#profile_pic_panel");
	recently_viewed_panel = $("#recently_viewed_panel");
	view_saved_users_panel = $("#view_saved_users_panel");
	browse_users_panel = $("#browse_users_panel");
	profilePictureDisplay = $("#profile_picture");
	//File upload
	chooseFileInput = $("#profile_picture_upload_input");
	uploadFileForm = $("#uploadimage");
	//Load page
	loadProfile();
	
	setClickFunctions();
});

function setProfileImg() {
	if (userInfo.profilePicId != null) {
		var url = "img/" + userInfo.profilePicId;
		profilePictureDisplay.attr("src", url);
	}else{
		profilePictureDisplay.attr("src", 'http://imgur.com/cucXLcU.png');
	}
}

function loadProfile() {
	var sessionCookie = getCookie(cookieName);
	var userId = getCookie(userIdCookie);
	$.ajax({
		type : "POST",
		url : getProfileCharacteristicsUrl,
		data : {
			"userId" : userId,
			"session" : sessionCookie
		}
	}).always(function(returnData) {
		if (returnData != "") {
			console.log(returnData);
			userInfo = JSON.parse(returnData);
			setProfileImg();
		} else {
			console.log("failed to get profile info");
		}
	});
}

function setClickFunctions() {
	chat_panel.click(function() {
		window.location.href = "chat.php";
	});
	attributes_panel.click(function() {
		window.location.href = "ProfileCharacteristics.php";
	});
	preferences_panel.click(function() {
		window.location.href = "Preferences.php";
	});

	profile_pic_panel.click(function() {
		//open file explorer
		chooseFileInput.click();
	});
	chooseFileInput.change(function() {
		//upload the selected file
		uploadFileForm.submit();
	});
	uploadFileForm.submit(function(event) {
		event.preventDefault();
		var sessionCookie = getCookie(cookieName);
		var userId = getCookie(userIdCookie);
		var dataBox = new FormData(this);
		dataBox.append("userId", userId);
		dataBox.append("session", sessionCookie);
		dataBox.append("setAsProfilePic", true);

		//make the ajax-php call
		$.ajax({
			type : "POST",
			url : "API/uploadImage.php",
			data : dataBox,
			contentType : false,
			cache : false,
			processData : false
		}).always(function(data) {
			console.log(data);
			loadProfile();//refreshes profile picture
		});
	});

	browse_users_panel.click(function() {
		window.location.href = "browse.php";
	});
    
    recently_viewed_panel.click(function(){
        window.location.href = "browse.php?which=viewed";
    });
    
    view_saved_users_panel.click(function(){
        window.location.href = "browse.php?which=saved";
    });
}
