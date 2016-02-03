"use-strict";
/**
 * Capture the inputs in .load
 */
var fnameInput;
var lnameInput;
var birthMonthInput;
var birthDayInput;
var birthYearInput;
// limit bio text box length
var bioInput;
var radioMale;
var radioFemale;
// check if male or female is check since they're just 2 radio
var heightInput;
var hairColorInput;
var eyeColorInput;
var bodyTypeInput;
// This is an array of radio buttons in the skinTone group
var skinToneRadioArray;
var maxSearchDistanceInput;

/*
 * Are the fields valid?
 */
var fnameValid = false;
var lnameValid = false;
var bioValid = true;//bio can be empty

/**
 * Begin
 */
$(window).load(function() {
	fnameInput = $("#inputFirstName");
	lnameInput = $("#inputLastName");
	birthMonthInput = $("#selectBirthMonth");
	birthDayInput = $("#selectBirthDay");
	birthYearInput = $("#selectBirthYear");
	// limit bio text box length
	bioInput = $("#textArea");
	//need to use radioMale.is(':checked') to check radios here
	radioMale = $("#radio_male");
	radioFemale = $("#radio_female");
	// check if male or female is check since they're just 2 radio
	heightInput = $("#inputHeight");
	hairColorInput = $("#selectHairColor");
	eyeColorInput = $("#selectEyeColor");
	bodyTypeInput = $("#selectBodyType");
	// This is an array of radio buttons in the skinTone group
	// cause use array[i].checked for radios here
	skinToneRadioArray = $("input[type=radio][name='skinTone']");
	maxSearchDistanceInput = $("#maxDistInput");

	// cancel button
	$("#cancel_prof_chars").click(function() {
		window.location.href = myProfilePage;
	});
	// save button
	$("#save_prof_chars").click(function() {
		//check if valid
		if(fnameValid && lnameValid && bioValid){
			save();
		}
	});
});

/**
 * Functions
 */

/*
 * Should only be called if input is valid
 */
function save() {
	var fname = fnameInput.val();
	var lname = lnameInput.val();
	var birthMonth = birthMonthInput.val();
	var birthDay = birthDayInput.val();
	var birthYear = birthYearInput.val();
	// must use YYYY-MM-DD format
	var birthdate = birthYear + "-" + birthMonth + "-" + birthDay;
	var bio = bioInput.val();
	var gender;
	console.log(radioMale.is(':checked'));
	if(radioMale.is(':checked')){gender = radioMale.val();}
	else{gender = radioFemale.val();}
	var height = heightInput.val();
	var hairColor = hairColorInput.val();
	var eyeColor = eyeColorInput.val();
	var bodyType = bodyTypeInput.val();
	
	var skinTone;
	for (var i = 0; i < skinToneRadioArray.length; i++) {
		if(skinToneRadioArray[i].checked){
			skinTone = $(skinToneRadioArray[i]).val();
			break;}}
	
	var maxSearchDistance = maxSearchDistanceInput.val();
	
	//For debugging
	console.log(" fname:"+fname+
	"\n lname:"+lname+
	"\n bMonth:"+birthMonth+
	"\n bDay:"+birthDay+
	"\n bYear:"+birthYear+
	"\n birthdate:"+birthdate+
	"\n bio:"+bio+
	"\n gender:"+gender+
	"\n height:"+height+
	"\n hairColor:"+hairColor+
	"\n eyeColor:"+eyeColor+
	"\n bodyType:"+bodyType+
	"\n skinTone:"+skinTone+
	"\n maxSearchDist:"+maxSearchDistance);
	
	/*
	 * Make call to server
	 */
	$.ajax({
		type: "POST",
		url: setProfileCharacteristicsUrl,
		data:{
			"fname":fname,
			"lname":lname,
			"birthdate":birthdate,
			"bio":bio,
			"gender":gender,
			"height":height,
			"hairColor":hairColor,
			"eyeColor":eyeColor,
			"bodyType":bodyType,
			"skinTone":skinTone,
			"maxSearchDist":maxSearchDistance
		}
	}).always(function(returnData){
		var json = JSON.parse(returnData);
		if(json.error){
			alert(json.err_message);
		}
		alert(json.error);
	});
}



/**
 * Modules; ignore everything below, I'm using angular for front end form validation
 */
var app = angular.module('appForm', []);

app.controller('ctrlName', function($scope) {

});

app.directive('validName', function() {
	return {
		require : 'ngModel',
		link : function(scope, element, attr, mCtrl) {
			function myValidation(value) {
				if (containsOnlyLetters(value)) {
					mCtrl.$setValidity('lettersOnly', true);
					if(attr.id == 'inputFirstName'){
						fnameValid = true;
					}else{
						lnameValid = true;
					}
					// console.log(attr.id);
					// console.log(scope);
					// console.log(element);
					// console.log(attr);
					// console.log(mCtrl);
				} else {
					mCtrl.$setValidity('lettersOnly', false);
					if(attr.id == 'inputFirstName'){
						fnameValid = false;
					}else{
						lnameValid = false;
					}
				}
				return value;
			}
			mCtrl.$parsers.push(myValidation);
		}
	};
});

app.directive('validBio', function() {
	return {
		require : 'ngModel',
		link : function(scope, element, attr, mCtrl) {
			function myValidation(value) {
				if (value.length <= 240) {
					mCtrl.$setValidity('lessThan240Chars', true);
					if(attr.id == 'textArea'){
						bioValid = true;
					}
					// console.log(scope);
					// console.log(element);
					// console.log(attr);
					// console.log(mCtrl);
				} else {
					mCtrl.$setValidity('lessThan240Chars', false);
					if(attr.id == 'textArea'){
						bioValid = false;
					}
				}
				return value;
			}


			mCtrl.$parsers.push(myValidation);
		}
	};
});
