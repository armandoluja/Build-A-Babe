"use-strict";

var inputLoginUsername;
var inputLoginPassword;

var fNameInput;
var lNameInput;
var inputGender;
var birthMonthInput;
var birthDayInput;
var birthYearInput;
var inputUsername;
var inputPassword;
var inputPasswordConfirm;
const fNameCharLimit = 16;
const lNameCharLimit = 30;

$(window).load(function() {
	inputLoginUsername = $("#inputUsername");
	inputLoginPassword = $("#inputPassword");
	
	fNameInput = $("#inputFirstname");
	lNameInput = $("#inputLastname");
	inputGender = $("#gender");
	birthMonthInput = $("#selectBirthMonth");
	birthDayInput = $("#selectBirthDay");
	birthYearInput = $("#selectBirthYear");
	inputUsername = $("#inputUsernameSignup");
	inputPassword = $("#inputPasswordSignup");
	inputPasswordConfirm = $("#inputPasswordAgainSignup");
	inputGender = $("#gender");

	if (getCookie(cookieName) != "") {
		var sessionCookie = getCookie(cookieName);
		var userId = getCookie(userIdCookie);
		$.ajax({
			type : "POST",
			url : loginCheckUrl,
			data : {
				"userId" : userId,
				"session" : sessionCookie
			}
		}).always(function(returnData) {
			//document.write(returnData);
			var json = JSON.parse(returnData);
			if (json.error == false) {
				window.location.href = myProfilePage;
			} else {
			}
		});
	}

	$("#login_btn").click(function() {
		login("", "", false);
	});

	$("#signup_btn").click(function() {
		var username = inputUsername.val();
		var pass = inputPassword.val();
		var passConfirm = inputPasswordConfirm.val();
		var usernameValidity = checkUsername(username);
		var passwordValidity = checkPassword(pass, passConfirm);

		var fName = fNameInput.val().trim();
		var lName = lNameInput.val().trim();
		
		var gender = inputGender.val();
		
		var birthMonth = birthMonthInput.val();
		var birthDay = birthDayInput.val();
		var birthYear = birthYearInput.val();
		
		if (usernameValidity != 0) {//invalid
			giveUsernameInvalidError(usernameValidity);
			return;
		}
		if (passwordValidity != 0) {//invalid
			givePasswordInvalidError(passwordValidity);
			return;
		}
		if(!isValidName(fName) && fName.length <= fNameCharLimit){
			alert("Please enter a valid first name.");
			return;
		}
		if(!isValidName(lName) && lName.length <= lNameCharLimit){
			alert("Please enter a valid last name.");
			return;
		}
		
		if(gender == 0){
			alert("Please select your gender.");
			return;
		}
		if(birthMonth == 0 || birthDay == 0 || birthYear == 0){
			alert("Please enter a valid birthdate.");
			return;
		}
		
		
		// must use YYYY-MM-DD format
		var birthdate = birthYear + "-" + birthMonth + "-" + birthDay;

		$.ajax({
			type : "POST",
			url : registerURL,
			data : {
				'username' : username,
				'password' : pass,
				'fName':fName,
				'lName':lName,
				'birthdate': birthdate,
				'gender':gender
			}
		}).always(function(returnData) {
			console.log(returnData);
			//'cast' to a json object
			// alert(JSON.stringify(returnData));
			var json = JSON.parse(returnData);
			if (json.error) {
				alert(json.err_message);
			} else {
				// we should make it so that if a user signs up successfully
				// they are logged in with the login function
				// this will create a session cookie and do everything
				// that we need
				login(username, pass, true);
			}
		});

	});

	//Log in or sign up on enter key pressed
	$(document).keypress(function(e) {
		if (e.which == 13) {
			if (inputUsername.val().length > 0 && inputPassword.val().length > 0 && inputPasswordConfirm.val().length > 0) {
				$("#signup_btn").trigger("click");
			} else {
				$("#login_btn").trigger("click");
			}
		}
	});

});

/**
 *If the parameters are passed and useOptionalParameters is true
 * then the function will log in using the parameters
 * if false, then it will use the values from the inputs
 * on the login page.
 */
function login(userNameOptional, passwordOptional, useOptionalParameters) {
	var username;
	var password;
	if (useOptionalParameters) {
		username = userNameOptional;
		password = passwordOptional;
	} else {
		username = inputLoginUsername.val();
		password = inputLoginPassword.val();
	}

	// if(username.length < 1 || password.length < 1){
	// alert("invalid username or password");
	// return;
	// }
	$.ajax({
		type : "POST",
		url : loginURL,
		data : {
			'username' : username,
			'password' : password
		}
	}).always(function(returnData) {
		//'cast' to a json object
		var json = JSON.parse(returnData);
		if (json.error) {
			if (json.err_pos === 1) {
				alert("Invalid username or password");
			} else if (json.err_pos === 2) {
				alert("Invalid username or password");
			} else if (json.err_pos === 3) {
				alert("Invalid username or password");
			} else if (json.err_pos === 4) {
				alert("Invalid username or password length");
			}

			//alert("invalid username/password :" + json.err_pos);
		} else {
			if (json.cookie != null && json.userId != null) {
				if (parseInt(json.cookie.length) == 40) {
					setCookie(cookieName, json.cookie);
					setCookie(userIdCookie, json.userId);
					window.location.href = myProfilePage;
					return;
				}
			}
			alert("cookie null...?");
		}
	});
}

/**
 *  Check if username is valid and return an error code if not,
 *  0: valid
 *  1: username too short
 * 	2: username too long
 * 	3: username invalid, "must contain only ... and cannot... " message
 * 	4: username is already taken
 * 	Server side validation is also needed for security
 *
 *
 *
 */
function checkUsername(username) {
	if (username.length < 3) {
		return 1;
	}
	if (username.length > 20) {
		return 2;
	}
	var reg = /^[a-zA-Z0-9._]{3,20}$/;
	var testReg = reg.test(username);
	if (!testReg) {
		return 3;
	}
	return 0;
}

/**
 * Check is password is valid and returns an error code if not,
 * returns an int, all punct are valid, as well as spaces
 *  0: valid
 * 	1: password too short
 * 	2: passwords dont match
 * @param {String} pass
 * @param {String} passConfirm
 */
function checkPassword(pass, passConfirm) {
	if (pass.length < minPasswordLength) {
		return 1;
	}
	if (pass !== passConfirm) {
		return 2;
	}
	return 0;
}

function giveUsernameInvalidError(code) {
	//TODO: alert invalid username
	//alert("invalid username" + code);
	if (code === 1) {
		alert("Invalid username");
	} else if (code === 2) {
		alert("Server failure");
	} else if (code === 3) {
		alert("Username is already taken");
	} else if (code === 4) {
		alert("Server failure");
	} else if (code === 5) {
		alert("Incorrect username or password length");
	}
}

function givePasswordInvalidError(code) {
	//TODO: alert invalid Password
	alert("invalid Password");
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
