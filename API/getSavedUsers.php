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

/*$justId = false;
if(isset($_POST['justId'])){
    if(strcasecmp(filter_var($_POST['justId'], FILTER_SANITIZE_STRING),"true")===0){
        $justId = true;
    }
}*/

$userId = $_POST['userId'];
$userId = filter_var($userId, FILTER_SANITIZE_STRING);

//if($justId){
    $q2 = $db -> prepare("Call getSavedUsersIds(:userId)");
	$q2 -> bindValue(':userId', $userId);
	$q2 -> execute();
	$outputJSON = "[";
	
	do{
		$row = $q2 -> fetch(PDO::FETCH_ASSOC);
		if($row != null){
			$outputJSON = $outputJSON . json_encode($row) . ",";
		}
	}while($row != null);
	$outputJSON = substr($outputJSON, 0, -1);
	$q2->closeCursor();
	$outputJSON = $outputJSON . "]";
	echo $outputJSON;
    exit;
//}

?>