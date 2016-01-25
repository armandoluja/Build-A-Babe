"use-strict";
function showMinAge(newValue) {
	var max = document.getElementById("inputMaxAge");
	if (max.value < parseInt(newValue)) {
		max.value = newValue;
		document.getElementById("maxAge").innerHTML = newValue;
	}
	document.getElementById("minAge").innerHTML = newValue;
}

function showMaxAge(newValue) {
	var min = document.getElementById("inputMinAge");
	if (min.value > newValue) {
		min.value = newValue;
		document.getElementById("minAge").innerHTML = newValue;
	}
	document.getElementById("maxAge").innerHTML = newValue;
}

function showHeight(newValue) {
	document.getElementById("height").innerHTML = calculateHeightDisplayString(newValue);
}

function showMinHeight(newValue) {
	var max = document.getElementById("inputMaxHeight");
	var val = calculateHeightDisplayString(newValue);
	if (max.value < newValue) {
		max.value = newValue;
		document.getElementById("maxHeight").innerHTML = val;
	}
	document.getElementById("minHeight").innerHTML = val;
}

function showMaxHeight(newValue) {
	var min = document.getElementById("inputMinHeight");
	var val = calculateHeightDisplayString(newValue);
	if (min.value > newValue) {
		min.value = newValue;
		document.getElementById("minHeight").innerHTML = val;
	}
	document.getElementById("maxHeight").innerHTML = val;
}

function calculateHeightDisplayString(inches){
	var feet = parseInt(inches / 12);
	var inches = inches % 12;
	return feet+ " ' " + inches + " \"";
}
