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
	//default
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
			echo '{"error": true, "err_pos": 2}';
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
	$earliestBirthdate = calcBirthdate($maxAge);
	$latestBirthdate = calcBirthdate($minAge);

	$which = 0;
	// 0 = browse with prefs, 1 = view all, 2 = saved , 3 = viewed
	$query = "";
	if (isset($_POST['which'])) {
		$which = $_POST['which'];
		if ($which == 0) {
			// browse with preferences
			//TODO: add to stored procs if time.
			$query = $db -> prepare("Select * from profile where 
			gender = '$genderPreference' and birthdate > '$earliestBirthdate' and birthdate < '$latestBirthdate' and 
			height < $maxHeight and height > $minHeight and (hairColor = $oneHair or hairColor = $twoHair) and 
			(eyeColor = $oneEye or eyeColor = $twoEye) and bodyType = $bodyType and skinTone = $skinTone");
		} else if ($which == 1) {
			// view all users
			$query = $db -> prepare("Call getProfilesOfGender(:genderType)");
			$query -> bindValue(':genderType', $genderPreference);
		} else if ($which == 2) {
			// view saved users
			$query = $db -> prepare("Select * from profile where id IN (Select savedId from saved_user where id = $userId)");
		} else if ($which == 3) {
			//view viewed users
			// $query = $db -> prepare("Select * from profile where id IN (Select vieweeId from viewed where viewerId = $userId)");
			$query = $db -> prepare("Select DISTINCT id,fName,lName,gender,hairColor,eyeColor,bodyType,skinTone,profilePicId,bio,birthdate,height from ((Select * from viewed join profile on profile.id = viewed.vieweeId where viewed.viewerId = $userId order by viewed.timeStamp desc) as A)");
		} else {
			exit ;
			// invalid param
		}
	}
	$query -> execute();
	if ($query -> rowCount() < 1) {
		echo '{"error": true, "err_pos": 3}';
		exit ;
	}
	$results = $query -> fetchAll();
	$query -> closeCursor();
	echo json_encode($results);
	exit ;
} else {
	// echo '{"error": true, "err_pos": 5}';
	exit ;
}

function calcBirthdate($age) {
	$date = date("Y-m-d");
	$arr = split("-", $date);
	$year = $arr[0];
	$birthYear = $year - $age;
	$date = $birthYear . "-" . $arr[1] . "-" . $arr[2];
	return $date;
}
?>