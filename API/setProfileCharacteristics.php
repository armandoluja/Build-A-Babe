<?php
include ('connection.php');
if (isset($_POST['session']) && isset($_POST['userId'])) {
	$session = $_POST['session'];
	$userId = $_POST['userId'];

	if (!isset($_POST['fname']) || !isset($_POST['lname']) 
	|| !isset($_POST['birthdate']) || !isset($_POST['bio']) 
	|| !isset($_POST['gender']) || !isset($_POST['height']) 
	|| !isset($_POST['hairColor']) || !isset($_POST['eyeColor']) 
	|| !isset($_POST['bodyType']) || !isset($_POST['skinTone']) 
	|| !isset($_POST['maxSearchDist'])) {
		// echo '{"error": true, "err_pos": 1}';
		exit ;
	}
	// varchar
	$fName = $_POST['fname'];
	$lName = $_POST['lname'];
	$birthdate = $_POST['birthdate'];
	$bio = $_POST['bio'];
	$gender = $_POST['gender'];
	//int
	$height = $_POST['height'];
	$hairColor = $_POST['hairColor'];
	$eyeColor = $_POST['eyeColor'];
	$bodyType = $_POST['bodyType'];
	$skinTone = $_POST['skinTone'];
	$maxSearchDist = $_POST['maxSearchDist'];

	// sanitize strings
	$session = filter_var($session, FILTER_SANITIZE_STRING);
	$userId = filter_var($userId, FILTER_SANITIZE_STRING);
	$fName = filter_var($fName, FILTER_SANITIZE_STRING);
	$lName = filter_var($lName, FILTER_SANITIZE_STRING);
	$bio = filter_var($bio, FILTER_SANITIZE_STRING);
	$gender = filter_var($gender, FILTER_SANITIZE_STRING);
	$birthdate = filter_var($birthdate, FILTER_SANITIZE_STRING);
	if($fName == "" || $lName == "" || $birthdate == "" || $gender == ""){
		// echo '{"error": true, "err_pos": 2}';
		exit;//required
	}
	
	// sanitize int's, value of 0 is valid (first filter)
	if ((filter_var($height, FILTER_VALIDATE_INT) === 0 || !filter_var($height, FILTER_VALIDATE_INT) === false)
	  && (filter_var($hairColor, FILTER_VALIDATE_INT) === 0 || !filter_var($hairColor, FILTER_VALIDATE_INT) === false)
	  && (filter_var($eyeColor, FILTER_VALIDATE_INT) === 0 || !filter_var($eyeColor, FILTER_VALIDATE_INT) === false)
	  && (filter_var($bodyType, FILTER_VALIDATE_INT) === 0 || !filter_var($bodyType, FILTER_VALIDATE_INT) === false)
	  && (filter_var($skinTone, FILTER_VALIDATE_INT) === 0 || !filter_var($skinTone, FILTER_VALIDATE_INT) === false)
	  && (filter_var($maxSearchDist, FILTER_VALIDATE_INT) === 0 || !filter_var($maxSearchDist, FILTER_VALIDATE_INT) === false)) {
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
	$isSet = $db -> prepare("Call isUserAttrSet(:userId)");
	$isSet -> bindValue(':userId', $userId);
	$isSet -> execute();
	$rowcount = $isSet->rowCount();//get row count then close cursor
	$isSet ->closeCursor();

	$query;
	if ($rowcount == 0) {
		$query = $db -> prepare("Call setAttributes(:userId,:fName,:lName,:gender,:hairColor,:eyeColor,:bodyType,:skinTone,:bio,:birthdate,:maxSearchDist)");
	} else {
		$query = $db -> prepare("Call updateAttributes(:userId,:fName,:lName,:gender,:hairColor,:eyeColor,:bodyType,:skinTone,:bio,:birthdate,:maxSearchDist)");
	}

	$query -> bindValue(':userId', $userId);
	$query -> bindValue(':fName', $fName);
	$query -> bindValue(':lName', $lName);
	$query -> bindValue(':gender', $gender);
	$query -> bindValue(':hairColor', $hairColor);
	$query -> bindValue(':eyeColor', $eyeColor);
	$query -> bindValue(':bodyType', $bodyType);
	$query -> bindValue(':skinTone', $skinTone);
	$query -> bindValue(':bio', $bio);
	$query -> bindValue(':birthdate', $birthdate);
	$query -> bindValue(':maxSearchDist', $maxSearchDist);
	
	$query ->execute();
	$query ->closeCursor();
	// echo '{"error": false}';
	exit;
} else {
	// echo '{"error": true, "err_pos": 5}';
	exit ;
}
?>