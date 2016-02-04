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
var bioValid = true;
//bio can be empty
var app;

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
		if (fnameValid && lnameValid && bioValid) {
			save();
		}
	});

	getProfileCharacteristics();
});

/**
 * Functions
 */

function getProfileCharacteristics() {
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
			var json = JSON.parse(returnData);
			setInputValues(json);
		} else {
			// fnameInput.css('background-color',"pink");
			fnameInput.addClass('ng-invalid');
			fnameInput.removeClass('ng-valid');
			lnameInput.addClass('ng-invalid');
			lnameInput.removeClass('ng-valid');
		}
	});
}

function setInputValues(json) {
	fnameInput.val(json.fName);
	lnameInput.val(json.lName);

	var date = json.birthdate.split("-");
	birthYearInput.val(date[0]);
	birthMonthInput.val(date[1]);
	birthDayInput.val(date[2]);
	bioInput.val(unescape(json.bio));

	if (json.gender == "M") {
		radioMale.prop('checked', true);
	} else {
		radioFemale.prop('checked', true);
	}

	// check if male or female is check since they're just 2 radio
	heightInput.val(json.height);
	//update the height display
	showHeight(json.height);
	hairColorInput.val(json.hairColor);
	eyeColorInput.val(json.eyeColor);
	bodyTypeInput.val(json.bodyType);
	// radio buttons are in an array
	var index = json.skinTone;
	//get the index
	$(skinToneRadioArray[index]).prop('checked', true);
	maxSearchDistanceInput.val(json.maxSearchDist);
	//update the max distance display
	showMaxDist(json.maxSearchDist);
}

/*
 * Should only be called if input is valid
 */
function save() {
	var fname = fnameInput.val().trim();
	var lname = lnameInput.val().trim();

	var birthMonth = birthMonthInput.val();
	var birthDay = birthDayInput.val();
	var birthYear = birthYearInput.val();
	// must use YYYY-MM-DD format
	var birthdate = birthYear + "-" + birthMonth + "-" + birthDay;
	var bio = escape(bioInput.val().trim());
	var gender;
	console.log(radioMale.is(':checked'));
	if (radioMale.is(':checked')) {
		gender = radioMale.val();
	} else {
		gender = radioFemale.val();
	}
	var height = heightInput.val();
	var hairColor = hairColorInput.val();
	var eyeColor = eyeColorInput.val();
	var bodyType = bodyTypeInput.val();

	var skinTone;
	for (var i = 0; i < skinToneRadioArray.length; i++) {
		if (skinToneRadioArray[i].checked) {
			skinTone = $(skinToneRadioArray[i]).val();
			break;
		}
	}

	var maxSearchDistance = maxSearchDistanceInput.val();

	//For debugging
	console.log(" fname:" + fname + " type:" + typeof (fname) + "\n lname:" + lname + " type:" + typeof (lname) + "\n bMonth:" + birthMonth + " type:" + typeof (birthMonth) + "\n bDay:" + birthDay + " type:" + typeof (birthDay) + "\n bYear:" + birthYear + " type:" + typeof (birthYear) + "\n birthdate:" + birthdate + " type:" + typeof (birthdate) + "\n bio:" + bio + " type:" + typeof (bio) + "\n gender:" + gender + " type:" + typeof (gender) + "\n height:" + height + " type:" + typeof (height) + "\n hairColor:" + hairColor + " type:" + typeof (hairColor) + "\n eyeColor:" + eyeColor + " type:" + typeof (eyeColor) + "\n bodyType:" + bodyType + " type:" + typeof (bodyType) + "\n skinTone:" + skinTone + " type:" + typeof (skinTone) + "\n maxSearchDist:" + maxSearchDistance + " type:" + typeof (maxSearchDistance));

	/*
	 * Make call to server
	 */
	var sessionCookie = getCookie(cookieName);
	var userId = getCookie(userIdCookie);
	$.ajax({
		type : "POST",
		url : setProfileCharacteristicsUrl,
		data : {
			"session" : sessionCookie,
			"userId" : userId,
			"fname" : fname,
			"lname" : lname,
			"birthdate" : birthdate,
			"bio" : bio,
			"gender" : gender,
			"height" : height,
			"hairColor" : hairColor,
			"eyeColor" : eyeColor,
			"bodyType" : bodyType,
			"skinTone" : skinTone,
			"maxSearchDist" : maxSearchDistance
		}
	}).always(function(returnData) {
		// alert(returnData);
	});
}

/**
 * Modules; ignore everything below, I'm using angular for front end form validation
 */
app = angular.module('appForm', []);

app.controller('ctrlName', function($scope) {

});

app.directive('validName', function() {
	return {
		require : 'ngModel',
		link : function(scope, element, attr, mCtrl) {
			function myValidation(value) {
				var text = $("#"+attr.id).val();
				if (containsOnlyLetters(text) && text.length > 0) {
					mCtrl.$setValidity('lettersOnly', true);
					if (attr.id == 'inputFirstName') {
						fnameValid = true;
						validateDOM(fnameInput);
					} else {
						lnameValid = true;
						validateDOM(lnameInput);
					}
				} else {
					mCtrl.$setValidity('lettersOnly', false);
					if (attr.id == 'inputFirstName') {
						fnameValid = false;
					} else {
						lnameValid = false;
					}
				}
				return value;
			}


			mCtrl.$parsers.push(myValidation);
		}
	};
});

function validateDOM(jQueryObject) {
	while (jQueryObject.hasClass('ng-invalid')) {
		jQueryObject.removeClass('ng-invalid');
	}
	if (!jQueryObject.hasClass('ng-valid')) {
		jQueryObject.addClass('ng-valid');
	}
}

app.directive('validBio', function() {
	return {
		require : 'ngModel',
		link : function(scope, element, attr, mCtrl) {
			function myValidation(value) {
				if (escape(value).length <= 240) {
					mCtrl.$setValidity('lessThan240Chars', true);
					if (attr.id == 'textArea') {
						bioValid = true;
					}
				} else {
					mCtrl.$setValidity('lessThan240Chars', false);
					if (attr.id == 'textArea') {
						bioValid = false;
					}
				}
				return value;
			}


			mCtrl.$parsers.push(myValidation);
		}
	};
});
