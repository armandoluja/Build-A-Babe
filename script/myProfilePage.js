"use-strict";
var chat_panel;
var attributes_panel;
var preferences_panel;
var gallery_panel;
var profile_pic_panel;
var recently_viewed_panel;
var browse_users_panel;

$(window).load(function() {
	chat_panel = $("#chat_panel");
	attributes_panel = $("#attributes_panel");
	preferences_panel = $("#preferences_panel");
	gallery_panel = $("#gallery_panel");
	profile_pic_panel = $("#profile_pic_panel");
	recently_viewed_panel = $("#recently_viewed_panel");
	view_stared_users_panel = $("#view_stared_users_panel");
	browse_users_panel = $("#browse_users_panel");

	setClickFunctions();
});

function setHoverFunctions(){
	
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
	// gallery_panel
	// profile_pic_panel
	// recently_viewed_panel
	// view_stared_users_panel
	browse_users_panel.click(function() {
		window.location.href = "browse.php";
	});
}
