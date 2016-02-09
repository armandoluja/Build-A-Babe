"use-strict";
var browseContainer;
var currentIndex;

$(window).load(function() {
	currentIndex = 0;
	browseContainer = $("#browse_container");
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
		//TODO: iterate over the rows of the json to generate profiles
		for (var i = 0; i < jsonArray.length; i++) {
			var profile = jsonArray[i];
			createProfileDOM(profile);
		}
		//TODO: update currentIndex accordingly
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
function createProfileDOM(json) {
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
	img.attr('src',"http://imgur.com/cucXLcU.png");
	//put everything together
	well.append(img);
	panelBody.append(well);
	panelHeading.append(firstname);
	panel.append(panelHeading);
	panel.append(panelBody);
	columnDiv.append(panel);
	// browseContainer.children().last().after(columnDiv);
	browseContainer.append(columnDiv);
}
