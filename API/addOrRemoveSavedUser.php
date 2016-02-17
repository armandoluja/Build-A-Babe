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
$savedId = $_POST['savedId'];
$userId = filter_var($userId, FILTER_SANITIZE_STRING);
$savedId = filter_var($savedId, FILTER_SANITIZE_STRING);

//check to see if user has other user saved
$q2 = $db -> prepare("Call isUserSaved(:userId, :savedId)");
	$q2 -> bindValue(':userId', $userId);
    $q2 -> bindValue(':savedId', $savedId);
	$q2 -> execute();
    if($q2 -> errorCode() != '00000'){
        $q2->closeCursor();
        echo '{"error": true}';
        exit;
    }
	$savedUserCount = $q2 -> rowCount();
    $q2->closeCursor();
    

    if($savedUserCount > 1){
        //we messed up
        echo '{"error": true}';
        exit;
    }
    
    if($savedUserCount == 1){
        //user is saved so remove from saved_user
        removeSaved($userId, $savedId, $db);
    }else{
        //user is not saved so add into saved_user
        addSaved($userId, $savedId, $db);
    }

function removeSaved($userId, $savedId, $db){
    $q3 = $db -> prepare("Call removeSavedUser(:userId, :savedId)");
	$q3 -> bindValue(':userId', $userId);
    $q3 -> bindValue(':savedId', $savedId);
	$q3 -> execute();
    if($q3 -> errorCode() != '00000'){
        $q3->closeCursor();
        echo '{"error": true}';
        exit;
    }else{
        $q3->closeCursor();
        echo '{"error": false, "removed": true, "added": false}';//print out that the user was removed
        exit;
    } 
}

function addSaved($userId, $savedId, $db){
    $q4 = $db -> prepare("Call addSavedUser(:userId, :savedId)");
	$q4 -> bindValue(':userId', $userId);
    $q4 -> bindValue(':savedId', $savedId);
	$q4 -> execute();
    if($q4 -> errorCode() != '00000'){
        $q4->closeCursor();
        echo '{"error": true}';
        exit;
    }else{
        $q4->closeCursor();
        echo '{"error": false, "removed": false, "added": true}';//print out that the user was added
        exit;
    } 
}

?>