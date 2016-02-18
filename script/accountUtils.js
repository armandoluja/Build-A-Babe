"use-strict";

$(window).load(function() {
	$("#signout_btn").click(function() {
		signout();
	});
});

function signout() {
	var sessionCookie = getCookie(cookieName);
	var userId = getCookie(userIdCookie);
	$.ajax({
		type : "POST",
		url : logoutUrl,
		data : {
			"userId" : userId,
			"session" : sessionCookie
		}
	}).always(function(returnData) {

		setCookie(userIdCookie, "");
		deleteCookie(userIdCookie);
		setCookie(cookieName, "");
		deleteCookie(cookieName);
		window.location.href = indexURL;
	});
}

function showMinAge(newValue) {
	newValue = parseInt(newValue);
	var max = document.getElementById("inputMaxAge");
	if (max.value < newValue) {
		max.value = newValue;
		document.getElementById("maxAge").innerHTML = newValue;
	}
	document.getElementById("minAge").innerHTML = newValue;
}

function showMaxAge(newValue) {
	newValue = parseInt(newValue);
	var min = document.getElementById("inputMinAge");
	if (min.value > newValue) {
		min.value = newValue;
		document.getElementById("minAge").innerHTML = newValue;
	}
	document.getElementById("maxAge").innerHTML = newValue;
}

function showHeight(newValue) {
	newValue = parseInt(newValue);
	document.getElementById("height").innerHTML = calculateHeightDisplayString(newValue);
}

function showMinHeight(newValue) {
	newValue = parseInt(newValue);
	var max = document.getElementById("inputMaxHeight");
	var val = calculateHeightDisplayString(newValue);
	if (max.value < newValue) {
		max.value = newValue;
		document.getElementById("maxHeight").innerHTML = val;
	}
	document.getElementById("minHeight").innerHTML = val;
}

function showMaxHeight(newValue) {
	newValue = parseInt(newValue);
	var min = document.getElementById("inputMinHeight");
	var val = calculateHeightDisplayString(newValue);
	if (min.value > newValue) {
		min.value = newValue;
		document.getElementById("minHeight").innerHTML = val;
	}
	document.getElementById("maxHeight").innerHTML = val;
}

function showMaxDist(newValue) {
	document.getElementById("maxDistRange").innerHTML = newValue;
}

function calculateHeightDisplayString(inches) {
	var feet = parseInt(inches / 12);
	var inches = inches % 12;
	return feet + "' " + inches + "\"";
}

function containsOnlyLetters(string) {
	return /^[a-z]+$/i.test(string);
}

function calcAge(yyyymmdd) {
	var dateString = yyyymmdd.split("-");
	var birthday = +new Date(dateString[0], dateString[1], dateString[2]);
	return ~~((Date.now() - birthday) / (31557600000));
}

function isValidName(text) {
	if (containsOnlyLetters(text) && text.length > 0) {
		return true;
	} else {
		return false;
	}
}

function getBodyType(num) {
	switch(parseInt(num)) {
	case 0:
		return "Skinny";
		
	case 1:
		return "Fit";
	case 2:
		return "Athletic";
	case 3:
		return "Curvy";
	case 4:
		return "Fat";
	default:
		return "Not set";
	}
}

function getEyeColor(num) {
	switch(parseInt(num)) {
	case 0:
		return "Dark Brown";
	case 1:
		return "Light Brown";
	case 2:
		return "Blue";
	case 3:
		return "Green";
	case 4:
		return "Hazel";
	default:
		return "Not set";
	}
}

function getHairColor(num) {
	switch(parseInt(num)) {
	case 0:
		return "Black";
	case 1:
		return "Light Brown";
	case 2:
		return "Dark Brown";
	case 3:
		return "Blonde";
	case 4:
		return "Red";
	default:
		return "Not set";
	}
}