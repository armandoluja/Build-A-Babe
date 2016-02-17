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
$userId = filter_var($userId, FILTER_SANITIZE_STRING);

$q1 = $db -> prepare("Call getAllMessages(:userId)");
	$q1 -> bindValue(':userId', $userId);
	$q1 -> execute();
	$outputJSON = "[";
	
	do{
		$row = $q1 -> fetch(PDO::FETCH_ASSOC);
		if($row != null){
			$outputJSON = $outputJSON . json_encode($row) . ",";
		}
	}while($row != null);
	$outputJSON = substr($outputJSON, 0, -1);
	$q1->closeCursor();
	$outputJSON = $outputJSON . "]";
	echo $outputJSON;
	/*if($rowC == 0){
		exit;
	}*/
?>