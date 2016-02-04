"use-strict";
/**
 * Capture the inputs in .load
 */
var radioMale;
var radioFemale;

var minAgeInput;
var maxAgeInput;

var minHeightInput;
var maxHeightInput;

var favHairColorInput;
var secondFavHairColorInput;
var leastHairColorInput;

var favEyeColorInput;
var secondFavEyeColorInput;

var bodyTypeInput;
// This is an array of radio buttons in the skinTone group
var skinToneRadioArray;

/**
 * Begin
 */
$(window).load(function() {

	radioMale = $("#radio_male");
	radioFemale = $("#radio_female");

	minAgeInput = $("#inputMinAge");
	maxAgeInput = $("#inputMaxAge");

	minHeightInput = $("#inputMinHeight");
	maxHeightInput = $("#inputMaxHeight");

	favHairColorInput = $("#selectFirstHairColor");
	secondFavHairColorInput = $("#selectSecondHairColor");
	leastHairColorInput = $("#selectLeastHairColor");

	favEyeColorInput = $("#selectEyeColor_1");
	secondFavEyeColorInput = $("#selectEyeColor_2");

	bodyTypeInput = $("#selectBodyType");
	// This is an array of radio buttons in the skinTone group
	// cause use array[i].checked to see if checked
	skinToneRadioArray = $("input[type=radio][name='skinTone']");
	// cancel button
	$("#cancel_preference_btn").click(function() {
		window.location.href = myProfilePage;
	});
	// save button
	$("#save_preference_btn").click(function() {
		save();
	});
	
	getPreferences();
});

function save() {
	var gender;
	if (radioMale.is(':checked')) {
		gender = radioMale.val();
	} else {
		gender = radioFemale.val();
	}
	var minAge = minAgeInput.val();
	var maxAge = maxAgeInput.val();
	var minHeight = minHeightInput.val();
	var maxHeight = maxHeightInput.val();
	var favHairColor = favEyeColorInput.val();
	var secondFavHairColor = secondFavHairColorInput.val();
	var leastHairColor = leastHairColorInput.val();
	var favEyeColor = favEyeColorInput.val();
	var secondFavEyeColor = secondFavEyeColorInput.val();
	var skinTone;
	for (var i = 0; i < skinToneRadioArray.length; i++) {
		if (skinToneRadioArray[i].checked) {
			skinTone = $(skinToneRadioArray[i]).val();
			break;
		}
	}
	var bodyType = bodyTypeInput.val();

	console.log(" gender:" + gender + " type:" + typeof (gender) + "\n minAge:" + minAge + " type:" + typeof (minAge) + "\n maxAge:" + maxAge + " type:" + typeof (maxAge) + "\n minHeight:" + minHeight + " type:" + typeof (minHeight) + 
	"\n maxHeight:" + maxHeight + " type:" + typeof (maxHeight) + "\n favHairColor:" + favHairColor + " type:" + typeof (favHairColor) + "\n secondFavHairColor:" + secondFavHairColor + " type:" + typeof (secondFavHairColor) + 
	"\n leastHairColor:" + leastHairColor + " type:" + typeof (leastHairColor) + "\n favEyeColor:" + favEyeColor + " type:" + typeof (favEyeColor) + "\n secondFavEyeColor:" + secondFavEyeColor + " type:" + typeof (secondFavEyeColor) + 
	"\n skinTone:" + skinTone + " type:" + typeof (skinTone)+
	"\n bodyType:" + bodyType + " type:" + typeof (bodyType));

	/*
	 * Make call to server
	 */
	var sessionCookie = getCookie(cookieName);
	var userId = getCookie(userIdCookie);
	$.ajax({
		type : "POST",
		url : setPreferencesUrl,
		data : {
			"session" : sessionCookie,
			"userId" : userId,
			"gender" : gender,
			"minAge" : minAge,
			"maxAge" : maxAge,
			"minHeight" : minHeight,
			"maxHeight" : maxHeight,
			"favHairColor" : favHairColor,
			"secondFavHairColor" : secondFavHairColor,
			"leastHairColor" : leastHairColor,
			"favEyeColor" : favEyeColor,
			"secondFavEyeColor" : secondFavEyeColor,
			"skinTone" : skinTone,
			"bodyType":bodyType
		}
	}).always(function(returnData) {
		// alert(returnData);
	});
}

function getPreferences() {
	var sessionCookie = getCookie(cookieName);
	var userId = getCookie(userIdCookie);
	$.ajax({
		type : "POST",
		url : getPreferencesUrl,
		data : {
			"userId" : userId,
			"session" : sessionCookie
		}
	}).always(function(returnData) {
		if (returnData != "") {
			console.log(returnData);
			var json = JSON.parse(returnData);
			setInputValues(json);
		} else {
			
		}
	});
}

function setInputValues(json) {
	if (json.gender == "M") {
		radioMale.prop('checked', true);
	} else {
		radioFemale.prop('checked', true);
	}

	minAgeInput.val(json.minAge);
	maxAgeInput.val(json.maxAge);
	//update the display
	showMinAge(json.minAge);
	showMaxAge(json.maxAge);
	

	minHeightInput.val(json.minHeight);
	maxHeightInput.val(json.maxHeight);
	//update the display
	showMinHeight(json.minHeight);
	showMaxHeight(json.maxHeight);

	favHairColorInput.val(json.oneHair);
	secondFavHairColorInput.val(json.twoHair);
	leastHairColorInput.val(json.leastHair);

	favEyeColorInput.val(json.oneEye);
	secondFavEyeColorInput.val(json.twoEye);

	bodyTypeInput.val(json.bodyType);
	//get index of radio
	var index = json.skinTone;
	$(skinToneRadioArray[index]).prop('checked', true);
	
}

