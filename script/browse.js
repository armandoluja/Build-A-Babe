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
var btnBigSaveBtn;

var currentIndex;
var users = [];

var savedUsers = [];

var curPos;

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
	viewProfileEyeColor = $("#view_profile_eye_color");
	viewProfileBodyType = $("#view_profile_body_type");
	pageHeader = $("#page_header_text");
	

	btnBackToResults = $("#back_to_results_button").click(function() {
		quickViewProfileContainer.css("display", "none");
		quickViewHeaderContainer.css("display", "none");
		browseContainer.css("display", "");
		browseHeaderContainer.css("display", "");
	});

	btnBigSaveBtn = $("#big_save_button");

	which = $("#which").html().trim();
	loadSavedUsers();
	loadProfiles(currentIndex, currentIndex + 20, which);
    
    $("#send_message").click(function(){
        var content = escape($("#message_content").val());
        if(content.length > 0 && content.length <= 256){
            $("#message_content").val("");
            if(sendMessage(users[curPos].id, content)){
               alert("Message Sent"); 
            }else{
                alert("Message Could Not Send");
            }
        }
        $('#message_content').focus();
    });
});

function loadSavedUsers() {
	savedUsers = [];
	var sessionCookie = getCookie(cookieName);
	var userId = getCookie(userIdCookie);
	$.ajax({
		async : false,
		type : "POST",
		url : getSavedUsersURL,
		data : {
			"userId" : userId,
			"session" : sessionCookie
		}
	}).always(function(returnData) {
		if (returnData != null) {
			var arr = JSON.parse(returnData);
			if (arr.error != null) {

			} else {
				for (var i = 0; i < arr.length; i++) {
					savedUsers.push(arr[i]);
				}
			}
		}
	});
}

function loadProfiles(startingIndex, howMany, which) {
	//TODO: USE STARTINGINDEX AND HOW MANY
	// ajax call get data from server and append to the div
	var sessionCookie = getCookie(cookieName);
	var userId = getCookie(userIdCookie);
	var jsonArray;
	$.ajax({
		async : false,
		type : "POST",
		url : getProfilesURL,
		data : {
			"userId" : userId,
			"session" : sessionCookie,
			"which" : which
		}
	}).always(function(returnData) {
		jsonArray = JSON.parse(returnData);
		if (jsonArray.error != null) {
			if (jsonArray.error == true) {
				if (jsonArray.err_pos == 3) {
					alert("No users match your preferences. Try changing them.");
				}
			}
		} else {
			// iterate over the rows of the json to generate profiles
			for (var i = 0; i < jsonArray.length; i++) {
				var profile = jsonArray[i];
				users[currentIndex + i] = profile;
				createProfileDOM(profile, currentIndex + i);
			}
			//update currentIndex accordingly
			currentIndex = currentIndex + jsonArray.length;
		}
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
	age.html("Age: " + calcAge(json.birthdate));
	var br1 = $('<br/>');
	var bio = $('<h4></h4>').html("Bio: " + unescape(json.bio));
	var br2 = $('<br/>');
	var buttonDiv = $('<div></div>').addClass("btn-group");
	buttonDiv.addClass('btn-group-justified');
	var btnVFP = $('<a></a>').addClass('btn');
	btnVFP.addClass('btn-default');
	btnVFP.attr("href", "#");
	btnVFP.html("View Full Profile");
	var btnSave = $('<a></a>').addClass('btn btn-default');
	btnSave.addClass('btn-default');
	btnSave.attr("href", "#");
	var userSaved = false;
	for (var i = 0; i < savedUsers.length; i++) {
		if (json.id == savedUsers[i].id) {
			btnSave.html("Saved");
			// btnSave.addClass("disabled");
			btnSave.click(function(event) {
				event.preventDefault();
				// alert("unsave user clicked for id: " + savedUsers[i].id);
				toggleSaved(json, this);
			});
			userSaved = true;
			break;
		}
	}
	if (!userSaved) {
		btnSave.html("Save");
		btnSave.click(function(event) {
			event.preventDefault();
			toggleSaved(json, this);
		});
	}

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

	btnVFP.click(function() {
		addToViewed(json.id);
		showQuickViewProfile(position, $(btnSave));
	});

	browseContainer.append(outerPanel);
}

function addToViewed(idOfOtherUser) {
	var sessionCookie = getCookie(cookieName);
	var userId = getCookie(userIdCookie);
	$.ajax({
		type : "POST",
		url : addUserViewedURL,
		data : {
			"session" : sessionCookie,
			"userId" : userId,
			"vieweeId" : idOfOtherUser
		}
	}).always(function(returnData) {
		console.log(returnData);
	});
}

function toggleSaved(savedUser, button) {
	// alert("save user clicked for ID: " + which);
	var sessionCookie = getCookie(cookieName);
	var userId = getCookie(userIdCookie);
	var which = savedUser.id;
	$.ajax({
		type : "POST",
		url : addOrRemoveSavedUserURL,
		data : {
			"session" : sessionCookie,
			"userId" : userId,
			"savedId" : which
		}
	}).always(function(returnData) {
		var json = JSON.parse(returnData);
		if (json.error == false) {
			if (json.removed == true) {
				$(button).html("Save");
				var newSavedUsers = [];
				for(var i = 0; i < savedUsers.length; i++){
					if(savedUsers[i].id != which){
						newSavedUsers.push(savedUsers[i]);
					}
				}
				savedUsers = newSavedUsers;
			} else {
				$(button).html("Saved");
				savedUsers.push(savedUser);
			}
		}
	});
}

/**
 * display the quick for for the specified user
 */
function showQuickViewProfile(positionInUsersArray, saveButtonFromBrowse) {
    curPos = positionInUsersArray;
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
	console.log(profileJson);
	viewProfileHeight.html("Height: " + calculateHeightDisplayString(profileJson.height));
	viewProfileHairColor.html("Hair Color: " + getHairColor(profileJson.hairColor));
	viewProfileEyeColor.html("Eye Color: " + getEyeColor(profileJson.eyeColor));
	viewProfileBodyType.html("Body Type: " + getBodyType(profileJson.bodyType));
	
	btnBigSaveBtn.unbind();
	var userSaved = false;
	for (var i = 0; i < savedUsers.length; i++) {
		if (profileJson.id == savedUsers[i].id) {
			btnBigSaveBtn.html("Saved");
			btnBigSaveBtn.click(function(event) {
				event.preventDefault();
				toggleSaved(profileJson, this);
				$(saveButtonFromBrowse).html("Saved");
			});
			userSaved = true;
			break;
		}
	}
	if (!userSaved) {
		btnBigSaveBtn.html("Save");
		btnBigSaveBtn.click(function(event) {
			event.preventDefault();
			toggleSaved(profileJson, this);
			$(saveButtonFromBrowse).html("Save");
		});
	}
	

	quickViewProfileContainer.css("display", "");
	quickViewHeaderContainer.css("display", "");
	browseContainer.css("display", "none");
	browseHeaderContainer.css("display", "none");
}




    


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
