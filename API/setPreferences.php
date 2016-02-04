<?php
include ('connection.php');
if (isset($_POST['session']) && isset($_POST['userId'])) {
	$session = $_POST['session'];
	$userId = $_POST['userId'];

	if (!isset($_POST['gender']) || !isset($_POST['minAge']) 
	|| !isset($_POST['maxAge']) || !isset($_POST['minHeight']) 
	|| !isset($_POST['maxHeight']) || !isset($_POST['favHairColor']) 
	|| !isset($_POST['secondFavHairColor']) || !isset($_POST['leastHairColor']) 
	|| !isset($_POST['favEyeColor']) || !isset($_POST['secondFavEyeColor']) 
	|| !isset($_POST['skinTone']) || !isset($_POST['bodyType'])) {
		// echo '{"error": true, "err_pos": 1}';
		exit ;
	}
	// varchar
	$gender = $_POST['gender'];
	$minAge = $_POST['minAge'];
	$maxAge = $_POST['maxAge'];
	$minHeight = $_POST['minHeight'];
	$maxHeight = $_POST['maxHeight'];
	//int
	$favHairColor = $_POST['favHairColor'];
	$secondFavHairColor = $_POST['secondFavHairColor'];
	$leastHairColor = $_POST['leastHairColor'];
	$favEyeColor = $_POST['favEyeColor'];
	$secondFavEyeColor = $_POST['secondFavEyeColor'];
	$skinTone = $_POST['skinTone'];
	$bodyType = $_POST['bodyType'];

	// sanitize strings
	$session = filter_var($session, FILTER_SANITIZE_STRING);
	$userId = filter_var($userId, FILTER_SANITIZE_STRING);
	$gender = filter_var($gender, FILTER_SANITIZE_STRING);
	if($gender == ""){
		// echo '{"error": true, "err_pos": 2}';
		exit;//required
	}
	
	// sanitize int's, value of 0 is valid (first filter)
	if ((filter_var($minAge, FILTER_VALIDATE_INT) === 0 || !filter_var($minAge, FILTER_VALIDATE_INT) === false)
	  && (filter_var($maxAge, FILTER_VALIDATE_INT) === 0 || !filter_var($maxAge, FILTER_VALIDATE_INT) === false)
	  && (filter_var($minHeight, FILTER_VALIDATE_INT) === 0 || !filter_var($minHeight, FILTER_VALIDATE_INT) === false)
	  && (filter_var($maxHeight, FILTER_VALIDATE_INT) === 0 || !filter_var($maxHeight, FILTER_VALIDATE_INT) === false)
	  && (filter_var($favHairColor, FILTER_VALIDATE_INT) === 0 || !filter_var($favHairColor, FILTER_VALIDATE_INT) === false)
	  && (filter_var($secondFavHairColor, FILTER_VALIDATE_INT) === 0 || !filter_var($secondFavHairColor, FILTER_VALIDATE_INT) === false)
	  && (filter_var($leastHairColor, FILTER_VALIDATE_INT) === 0 || !filter_var($leastHairColor, FILTER_VALIDATE_INT) === false)
	  && (filter_var($favEyeColor, FILTER_VALIDATE_INT) === 0 || !filter_var($favEyeColor, FILTER_VALIDATE_INT) === false)
	  && (filter_var($secondFavEyeColor, FILTER_VALIDATE_INT) === 0 || !filter_var($secondFavEyeColor, FILTER_VALIDATE_INT) === false)
	  && (filter_var($skinTone, FILTER_VALIDATE_INT) === 0 || !filter_var($skinTone, FILTER_VALIDATE_INT) === false)
	  && (filter_var($bodyType, FILTER_VALIDATE_INT) === 0 || !filter_var($bodyType, FILTER_VALIDATE_INT) === false)) {
		// valid
	} else {
		// not valid
		// echo '{"error": true, "err_pos": 3}';
		exit;
	}

	//Check that request is from a valid login
	$q1 = $db -> prepare("Call loginCheck(:cookie, :userId)");
	$q1 -> bindValue(':cookie', $session);
	$q1 -> bindValue(':userId', $userId);
	$q1 -> execute();
	$rowC = $q1 -> rowCount();
	$q1->closeCursor();
	if ($rowC != 1) {
		//invalid login
		// echo '{"error": true, "err_pos": 4}';
		exit ;
	}
	//Check if user attributes have been set
	$isSet = $db -> prepare("Call isUserPrefSet(:userId)");
	$isSet -> bindValue(':userId', $userId);
	$isSet -> execute();
	$rowcount = $isSet->rowCount();//get row count then close cursor
	$isSet ->closeCursor();

	$query;
	if ($rowcount == 0) {
		$query = $db -> prepare("Call setPreferences(:userId,:minAge,:maxAge,:gender,:minHeight,:maxHeight,:oneHair,:twoHair,:leastHair,:oneEye,:twoEye,:bodyType,:skinTone)");
	} else {
		$query = $db -> prepare("Call updatePreferences(:userId,:minAge,:maxAge,:gender,:minHeight,:maxHeight,:oneHair,:twoHair,:leastHair,:oneEye,:twoEye,:bodyType,:skinTone)");
	}

	$query -> bindValue(':userId', $userId);
	$query -> bindValue(':minAge', $minAge);
	$query -> bindValue(':maxAge', $maxAge);
	$query -> bindValue(':gender', $gender);
	$query -> bindValue(':minHeight', $minHeight);
	$query -> bindValue(':maxHeight', $maxHeight);
	$query -> bindValue(':oneHair', $favHairColor);
	$query -> bindValue(':twoHair', $secondFavHairColor);
	$query -> bindValue(':leastHair', $leastHairColor);
	$query -> bindValue(':oneEye', $favEyeColor);
	$query -> bindValue(':twoEye', $secondFavEyeColor);
	$query -> bindValue(':bodyType',$bodyType);
	$query -> bindValue(':skinTone',$skinTone);
	
	$query ->execute();
	$query ->closeCursor();
	// echo '{"error": false}';
	exit;
} else {
	// echo '{"error": true, "err_pos": 5}';
	exit ;
}
?>