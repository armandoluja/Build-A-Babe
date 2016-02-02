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
$(window).load(function(){
	
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
	$("#cancel_preference_btn").click(function(){
		window.location.href = myProfilePage;
	});
	// save button
	$("#save_preference_btn").click(function(){
		
	});
});

