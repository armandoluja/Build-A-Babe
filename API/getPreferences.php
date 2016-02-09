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
	$q1->closeCursor();
	if ($rowC != 1) {
		//invalid login
		// echo '{"error": true, "err_pos": 4}';
		exit ;
	}

	//Check if user preferences have been set
	$isSet = $db -> prepare("Call isUserPrefSet(:userId)");
	$isSet -> bindValue(':userId', $userId);
	$isSet -> execute();
	$rowcount = $isSet->rowCount();//get row count then close cursor
	$isSet ->closeCursor();
	$query;
	if ($rowcount == 0) {
		// this user does not have preferences set return empty json
		exit;
	} else {
		$query = $db -> prepare("Call getPreferences(:userId)");
	}
	
	// get the user's preferences
	$query ->bindValue(':userId',$userId);
	$query ->execute();
	//check that there is only one result, since a user shouldn't have more than 1 preference
	$rowCount = $query->rowCount();
	if($rowCount != 1){
		exit;
	}
	$preferences = $query->fetch();
	$query ->closeCursor();
	
	echo json_encode($preferences);
	// echo '{"error": false}';
	exit;
} else {
	// echo '{"error": true, "err_pos": 5}';
	exit ;
}
?>