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
	
	//TODO: figure out which gender to search for.
	
	$getProfs = $db -> prepare("Call getProfilesOfGender(:genderType)");
	$getProfs ->bindValue(':genderType','M');
	$getProfs ->execute();
	
	$rowC = $getProfs -> rowCount();
	if ($rowC < 1) {
		// no results
		exit ;
	}
	
	$ar = $getProfs ->fetchAll();
	$getProfs ->closeCursor();
	
	echo json_encode($ar);
	// echo '{"error": false}';
	exit;
} else {
	// echo '{"error": true, "err_pos": 5}';
	exit ;
}
?>