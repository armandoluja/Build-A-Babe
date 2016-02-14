<?php
include ('connection.php');
if (isset($_POST['session']) && isset($_POST['userId'])) {
	$session = $_POST['session'];
	$userId = $_POST['userId'];

	//sanitize
	$session = filter_var($session, FILTER_SANITIZE_STRING);
	$userId = filter_var($userId, FILTER_SANITIZE_STRING);

	//Check that request is from a valid login
	$q1 = $db -> prepare("Call loginCheck(:cookie, :userId)");
	$q1 -> bindValue(':cookie', $session);
	$q1 -> bindValue(':userId', $userId);
	$q1 -> execute();
	$rowC = $q1 -> rowCount();
	$q1 -> closeCursor();
	if ($rowC != 1) {
		//invalid login
		echo '{"error": true, "err_pos": 1}';
		exit ;
	}

	//Check if user attributes have been set
	$isSet = $db -> prepare("Call isUserPrefSet(:userId)");
	$isSet -> bindValue(':userId', $userId);
	$isSet -> execute();
	$rowcount = $isSet -> rowCount();
	$isSet -> closeCursor();

	$genderPreference = 'M';
	$minAge = 18;
	$maxAge = 100;
	$minHeight = 36;
	$maxHeight = 96;
	$oneHair = null;
	$twoHair = null;
	$leastHair = null;
	$oneEye = null;
	$twoEye = null;
	$bodyType = null;
	$skinTone = null;

	if ($rowcount == 0) {
		// no preferences set; show default, males
	} else {
		// get preferences, browse with them.
		$preferences = $db -> prepare("Call getPreferences(:userId)");
		$preferences -> bindValue(':userId', $userId);
		$preferences -> execute();
		$rowCount = $preferences -> rowCount();
		if ($rowCount != 1) {
			exit ;
			// something is wrong if they have more than 1 preference
		}
		$preferenceResult = $preferences -> fetch();
		$preferences -> closeCursor();
		// change the default preference here
		$genderPreference = $preferenceResult["gender"];
		$minAge = $preferenceResult["minAge"];
		$maxAge = $preferenceResult["maxAge"];
		$minHeight = $preferenceResult["minHeight"];
		$maxHeight = $preferenceResult["maxHeight"];
		$oneHair = $preferenceResult["oneHair"];
		$twoHair = $preferenceResult["twoHair"];
		$leastHair = $preferenceResult["leastHair"];
		$oneEye = $preferenceResult["oneEye"];
		$twoEye = $preferenceResult["twoEye"];
		$bodyType = $preferenceResult["bodyType"];
		$skinTone = $preferenceResult["skinTone"];
	}


	
	
	//getprofiles*
	$getProfs = $db -> prepare("Call getProfilesOfGender(:genderType)");
	$getProfs -> bindValue(':genderType', $genderPreference);
	$getProfs -> execute();
	$rowC = $getProfs -> rowCount();
	if ($rowC < 1) {
		// no results
		exit ;
	}

	$ar = $getProfs -> fetchAll();
	$getProfs -> closeCursor();
	echo json_encode($ar);
	exit ;
} else {
	// echo '{"error": true, "err_pos": 5}';
	exit ;
}
?>