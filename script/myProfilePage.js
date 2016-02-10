"use-strict";
var chat_panel;
var attributes_panel;
var preferences_panel;
var gallery_panel;
var profile_pic_panel;
var recently_viewed_panel;
var browse_users_panel;
var chooseFileInput;
//trigger this to open file explorer
var uploadImageForm;
//submit this to upload the file

$(window).load(function() {
	chat_panel = $("#chat_panel");
	attributes_panel = $("#attributes_panel");
	preferences_panel = $("#preferences_panel");
	gallery_panel = $("#gallery_panel");
	profile_pic_panel = $("#profile_pic_panel");
	recently_viewed_panel = $("#recently_viewed_panel");
	view_stared_users_panel = $("#view_stared_users_panel");
	browse_users_panel = $("#browse_users_panel");
	//File upload
	chooseFileInput = $("#profile_picture_upload_input");
	uploadFileForm = $("#uploadimage");

	setClickFunctions();
});

function setHoverFunctions() {

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
		dataBox.append("session",sessionCookie);
		
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
		});
	});

	// gallery_panel
	// profile_pic_panel
	// recently_viewed_panel
	// view_stared_users_panel
	browse_users_panel.click(function() {
		window.location.href = "browse.php";
	});
}
