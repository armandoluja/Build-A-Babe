"use-strict";
var browseContainer;
var quickViewProfileContainer;

var browseHeaderContainer;
var quickViewHeaderContainer;

// the display fields for quick view
var viewProfileBio;
var viewProfileFullName;
var viewProfileImg;
var viewProfileAge;
var viewProfileHeight;
var viewProfileHairColor;
var pageHeader;

//buttons
var btnBackToResults;
var btnViewFullProfile;

var currentIndex;
var users = [];

$(window).load(function() {
	currentIndex = 0;
	browseContainer = $("#browse_container");
	browseHeaderContainer = $("#browse_header_container");

	quickViewProfileContainer = $("#quick_view_profile_container");
	quickViewHeaderContainer = $("#quick_view_button_container");
	viewProfileBio = $("#view_profile_bio");
	viewProfileFullName = $("#full_name");
	viewProfileImg = $("#view_profile_pic");
	viewProfileAge = $("#view_profile_age");
	viewProfileHeight = $("#view_profile_height");
	viewProfileHairColor = $("#view_profile_hair_color");
	pageHeader = $("#page_header_text");

	btnBackToResults = $("#back_to_results_button").click(function() {
		quickViewProfileContainer.css("display", "none");
		quickViewHeaderContainer.css("display", "none");
		browseContainer.css("display", "");
		browseHeaderContainer.css("display", "");
	});

	btnViewFullProfile = $("#view_full_profile_button");
	//TODO: use it

	loadProfiles(currentIndex, currentIndex + 20);
});

function loadProfiles(startingIndex, howMany) {
	//TODO: USE STARTINGINDEX AND HOW MANY
	// ajax call get data from server and append to the div
	var sessionCookie = getCookie(cookieName);
	var userId = getCookie(userIdCookie);
	var jsonArray;
	$.ajax({
        async: false,
		type : "POST",
		url : getProfilesURL,
		data : {
			"userId" : userId,
			"session" : sessionCookie
		}
	}).always(function(returnData) {
		jsonArray = JSON.parse(returnData);
		// iterate over the rows of the json to generate profiles
		for (var i = 0; i < jsonArray.length; i++) {
			var profile = jsonArray[i];
			users[currentIndex + i] = profile;
			createProfileDOM(profile, currentIndex + i);
		}
		//update currentIndex accordingly
		currentIndex = currentIndex + jsonArray.length;
	});

}

/**
 * Load more as the bottom of the page is reached.
 */
$(window).scroll(function() {
	if ($(window).scrollTop() == $(document).height() - $(window).height()) {
		// loadProfiles(currentIndex, currentIndex + 10);
	}
});

/**
 * create the dom element to append to the browse container,
 * and append it.
 */
function createProfileDOM(json, position) {
	var outerPanel = $('<div></div>').addClass("panel panel-default");
	var panelHeading = $('<div></div>').addClass("panel-heading");
		//inside panel heading
		var username = $('<b></b>').html(json.fName);
		
		panelHeading.append(username);
		outerPanel.append(panelHeading);
		
	var panelBody = $('<div></div>').addClass("panel-body");
	//inside panel body
	var imagePanel = $('<div></div>').addClass("panel-body");
	imagePanel.addClass('col-sm-4');
		//inside imagePanel 
		var imageWell = $('<div></div>').addClass("well");
		var img = $('<img/>').addClass('browse-image');
		if (json.profilePicId != null) {
			var url = "img/" + json.profilePicId;
			img.attr("src", url);
		} else {
			img.attr("src", 'http://imgur.com/cucXLcU.png');
		}
		imageWell.append(img);
		imagePanel.append(imageWell);
		panelBody.append(imagePanel);
		
	var infoPanel = $('<div></div>').addClass("panel-body");
	infoPanel.addClass('col-sm-8');
	//inside info
	var infoWell = $('<div></div>').addClass("well");
	//inside well
	var p = $('<p></p>');
	//inside p
	var age = $('<h4></h4>');
	age.html("Age: "+calcAge(json.birthdate));
	var br1 = $('<br/>');
	var bio = $('<h4></h4>').html("Bio: " + unescape(json.bio));
	var br2 = $('<br/>');
	var buttonDiv = $('<div></div>').addClass("btn-group");
	buttonDiv.addClass('btn-group-justified');
	var btnVFP = $('<a></a>').addClass('btn');
	btnVFP.addClass('btn-default');
	btnVFP.attr("href","#");
	btnVFP.html("View Full Profile");
	var btnSave = $('<a></a>').addClass('btn btn-default');
	btnSave.addClass('btn-default');
	btnSave.attr("href","#");
	btnSave.html("Save");
	
	buttonDiv.append(btnVFP);
	buttonDiv.append(btnSave);
	p.append(age);
	p.append(br1);
	p.append(bio);
	p.append(br2);
	p.append(buttonDiv);
	infoWell.append(p);
	infoPanel.append(infoWell);
	panelBody.append(infoPanel);
	outerPanel.append(panelBody);
	
	btnVFP.click(function(){
		showQuickViewProfile(position);
	});
	
	browseContainer.append(outerPanel);

	
	// var columnDiv = $('<div></div>').addClass("col-sm-12 browse-col");
	// var panel = $('<div></div>').addClass("panel panel-default");
	// var panelHeading = $('<div></div>').addClass("panel-heading");
	// var firstname = $('<b></b>');
	// var panelBody = $('<div></div>').addClass("panel-body");
	// var well = $('<div></div>').addClass("well");
	// var profilePictureDisplay = $("<img/>").addClass("browse-image");
// 
	// //Set first name
	// firstname.html(json.fName);
	// //Set profile img url
	// if (json.profilePicId != null) {
		// var url = "img/" + json.profilePicId;
		// profilePictureDisplay.attr("src", url);
	// } else {
		// profilePictureDisplay.attr("src", 'http://imgur.com/cucXLcU.png');
	// }
	// //put everything together
	// well.append(profilePictureDisplay);
	// panelBody.append(well);
	// panelHeading.append(firstname);
	// panel.append(panelHeading);
	// panel.append(panelBody);
	// columnDiv.append(panel);
// 
	// columnDiv.click(function() {
		// showQuickViewProfile(position);
	// });
	// // browseContainer.children().last().after(columnDiv);
	// browseContainer.append(columnDiv);
}

/**
 * display the quick for for the specified user
 */
function showQuickViewProfile(positionInUsersArray) {
	//TODO: set the redirect path for the full profile button
	var profileJson = users[positionInUsersArray];

	// the display fields for quick view
	viewProfileBio.html(unescape(profileJson.bio));
	viewProfileFullName.html(profileJson.fName + " " + profileJson.lName);
	if (profileJson.profilePicId != null) {
		var url = "img/" + profileJson.profilePicId;
		viewProfileImg.attr("src", url);
	} else {
		viewProfileImg.attr("src", 'http://imgur.com/cucXLcU.png');
	}
	viewProfileAge.html("Age: " + calcAge(profileJson.birthdate));
	viewProfileHeight.html("Height: " + calculateHeightDisplayString(profileJson.height));
	viewProfileHairColor.html("Hair color: " + profileJson.hairColor);

	quickViewProfileContainer.css("display", "");
	quickViewHeaderContainer.css("display", "");
	browseContainer.css("display", "none");
	browseHeaderContainer.css("display", "none");
}
