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

	//Check if user attributes have been set
	$isSet = $db -> prepare("Call isUserAttrSet(:userId)");
	$isSet -> bindValue(':userId', $userId);
	$isSet -> execute();
	$rowcount = $isSet->rowCount();//get row count then close cursor
	$isSet ->closeCursor();
	$query;
	if ($rowcount == 0) {
		// this user does not have attributes set return empty json
		exit;
	} else {
		$query = $db -> prepare("Call getAttributes(:userId)");
	}
	
	// get the user's attributes
	$query ->bindValue(':userId',$userId);
	$query ->execute();
	//check that there is only one result, since a user shouldn't have more than 1 profile
	//characteristics entries
	$rowCount = $query->rowCount();
	if($rowCount != 1){
		exit;
	}
	$profileCharacteristics = $query->fetch();
	$query ->closeCursor();
	
	echo json_encode($profileCharacteristics);
	// echo '{"error": false}';
	exit;
} else {
	// echo '{"error": true, "err_pos": 5}';
	exit ;
}
?>