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

$userId = $_POST['targetUserId'];
$userId = filter_var($userId, FILTER_SANITIZE_STRING);

$q1 = $db -> prepare("Call getName(:userId)");
	$q1 -> bindValue(':userId', $userId);
	$q1 -> execute();
	$row = $q1 -> fetch(PDO::FETCH_ASSOC);
	echo json_encode($row);
	$q1->closeCursor();
?>