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
$userId = $_POST['userId'];

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