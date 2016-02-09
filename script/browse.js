"use-strict";
var browseContainer;
var quickViewProfileContainer;
// the display fields for quick view
var viewProfileBio;
var viewProfileFullName;
var viewProfileImg;
var viewProfileAge;
var viewProfileHeight;
var viewProfileHairColor;

var currentIndex;
var users = [];

$(window).load(function() {
	currentIndex = 0;
	browseContainer = $("#browse_container");

	quickViewProfileContainer = $("#quick_view_profile_container");
	viewProfileBio = $("#view_profile_bio");
	viewProfileFullName = $("#full_name");
	viewProfileImg = $("#view_profile_pic");
	viewProfileAge = $("#view_profile_age");
	viewProfileHeight = $("#view_profile_height");
	viewProfileHairColor = $("#view_profile_hair_color");

	loadProfiles(currentIndex, currentIndex + 20);
});

function loadProfiles(startingIndex, howMany) {
	//TODO: USE STARTINGINDEX AND HOW MANY
	// ajax call get data from server and append to the div
	var sessionCookie = getCookie(cookieName);
	var userId = getCookie(userIdCookie);
	var jsonArray;
	$.ajax({
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
	var columnDiv = $('<div></div>').addClass("col-sm-3");
	var panel = $('<div></div>').addClass("panel panel-default");
	var panelHeading = $('<div></div>').addClass("panel-heading");
	var firstname = $('<b></b>');
	var panelBody = $('<div></div>').addClass("panel-body");
	var well = $('<div></div>').addClass("well");
	var img = $("<img/>").addClass("gallery-image");

	//Set first name
	firstname.html(json.fName);
	//Set profile img url
	img.attr('src', "http://imgur.com/cucXLcU.png");
	//put everything together
	well.append(img);
	panelBody.append(well);
	panelHeading.append(firstname);
	panel.append(panelHeading);
	panel.append(panelBody);
	columnDiv.append(panel);

	columnDiv.click(function() {
		showQuickViewProfile(position);
	});
	// browseContainer.children().last().after(columnDiv);
	browseContainer.append(columnDiv);
}

/**
 * display the quick for for the specified user
 */
function showQuickViewProfile(positionInUsersArray) {
	var profileJson = users[positionInUsersArray];
	
	// the display fields for quick view
	viewProfileBio.html(unescape(profileJson.bio));
	viewProfileFullName.html(profileJson.fName + " " + profileJson.lName);
	// viewProfileImg
	viewProfileAge.html("Age: "+calcAge(profileJson.birthdate));
	viewProfileHeight.html("Height: " + calculateHeightDisplayString(profileJson.height));
	viewProfileHairColor.html("Hair color: " + profileJson.hairColor);
	
	
	quickViewProfileContainer.css("display","");
	browseContainer.css("display","none");
}
