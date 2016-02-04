<?php
include ('connection.php');
if (isset($_POST['session']) && isset($_POST['userId'])) {
	$session = $_POST['session'];
	$userId = $_POST['userId'];

	//Check that request is from a valid login
	$q1 = $db -> prepare("Call loginCheck(:cookie, :userId)");
	$q1 -> bindValue(':cookie', $session);
	$q1 -> bindValue(':userId', $userId);
	$q1 -> execute();

	if ($q1 -> rowCount() != 1) {
		//invalid login
		// echo '{"error": true, "err_pos": 4}';
		exit ;
	}
	$q1->closeCursor();

	//Check if user attributes have been set
	$isSet = $db -> prepare("Call isUserAttrSet(:userId)");
	$isSet -> bindValue(':userId', $userId);
	$isSet -> execute();
	$rowcount = $isSet->rowCount();//get row count then close cursor
	$isSet ->closeCursor();

	$query;
	if ($rowcount == 0) {
		// this user does not have attributes set
	} else {
		$query = $db -> prepare("Call getAttributes(:userId)");
	}
	$query ->bindValue(':userId',$userId);
	$query ->execute();
	$query ->closeCursor();
	// echo '{"error": false}';
	exit;
} else {
	// echo '{"error": true, "err_pos": 5}';
	exit ;
}
?>