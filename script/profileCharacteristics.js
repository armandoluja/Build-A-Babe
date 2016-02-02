"use-strict";
var valid_name = false;
$(window).load(function(){
	var fnameInput = $("#inputFirstName");
	var lnameInput = $("#inputLastName");
	var birthMonthInput= $("#selectBirthMonth");
	var birthDayInput= $("#selectBirthDay");
	var birthYearInput= $("#selectBirthYear");
	// limit bio text box length
	var bioInput = $("#textArea");
	var radioMale = $("#radio_male");
	var radioFemale = $("#radio_female");
	// check if male or female is check since they're just 2 radio
	var heightInput = $("#inputHeight");
	var hairColorInput = $("#selectHairColor");
	var eyeColorInput = $("#selectEyeColor");
	var bodyTypeInput = $("#selectBodyType");
	// This is an array of radio buttons in the skinTone group
	var skinToneRadioArray = $("#input[type=radio][name='skinTone']");
	var maxSearchDistanceInput = $("#maxDistInput");
	// cancel button
	$("#cancel_prof_chars");
	// save button
	$("#save_prof_chars");
});


/**
 * Modules
 */
var app = angular.module('appForm',[]);

app.controller('ctrlName', function($scope){
	
});

app.directive('validName', function() {
  return {
    require: 'ngModel',
    link: function(scope, element, attr, mCtrl) {
      function myValidation(value) {
        if (containsOnlyLetters(value)) {
          mCtrl.$setValidity('charE', true);
        } else {
          mCtrl.$setValidity('charE', false);
        }
        return value;
      }
      mCtrl.$parsers.push(myValidation);
    }
  };
});