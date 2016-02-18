<?php
include ('connection.php');
if (isset($_POST['session']) && isset($_POST['userId'])) {
	$session = $_POST['session'];
	$userId = $_POST['userId'];
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
		echo '{"error": true}';
		exit;
	}
} else {
	echo '{"error": true}';
	exit;
}

$userId = $_POST['userId'];
$vieweeId = $_POST['vieweeId'];
$userId = filter_var($userId, FILTER_SANITIZE_STRING);
$vieweeId = filter_var($vieweeId, FILTER_SANITIZE_STRING);

//check to see if user has other user saved
$q2 = $db -> prepare("Call addUserViewed(:userId, :vieweeId)");
	$q2 -> bindValue(':userId', $userId);
    $q2 -> bindValue(':vieweeId', $vieweeId);
	$q2 -> execute();
    if($q2 -> errorCode() != '00000'){
        $q2->closeCursor();
        echo '{"error": true}';
        exit;
    }else{
        $q2->closeCursor();
        echo '{"error": false}';
        exit;
    }
?>