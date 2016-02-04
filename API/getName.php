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

// TODO sanitize input
$userId = $_POST['targetUserId'];

$q1 = $db -> prepare("Call getName(:userId)");
	$q1 -> bindValue(':userId', $userId);
	$q1 -> execute();
	$row = $q1 -> fetch(PDO::FETCH_ASSOC);
	echo json_encode($row);
	$q1->closeCursor();
?>